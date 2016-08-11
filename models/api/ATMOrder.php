<?php

namespace app\models\api;

use Yii;
use yii\web\ServerErrorHttpException;
use yii\base\Model;
use app\models\atm\arATMOrder;
use app\models\atm\arATMOrderStatus;
use app\models\atm\arATMOrderTech;
use app\models\atm\arATMOrderRemark;
use app\models\atm\arSprATMOrderTech;
use app\common\Convert;
use app\models\api\Mail;

class ATMOrder extends Model {

	public function save($fields, Mail $mail) {

		#Yii::info(['ATMOrder Save!', 'mail', $mail, 'fields', $fields], 'parse');
		#Yii::info(['ATMOrder Save!', 'fields', $fields], 'parse');
		$trans = arATMOrder::getDb()->beginTransaction();
		try {
			#Yii::info(['Save!', 'mail', $mail], 'parse');
			$atm = new arATMOrder();
			$ast = new arATMOrderStatus();
			$atc = new arATMOrderTech();
			$tech = new arSprATMOrderTech();
			
			$atm->attributes = $fields;
			$atm->Serial = trim(str_replace('-', '', $atm->Serial));
			$atm->EnterDate = Convert::Date2SQLiteDate($atm->EnterDate);
			if ($atm->save() === false) {
				if (($atm = arATMOrder::find()->Where(['Number' => $fields['Number']])->one()) === null) {
					throw new \Exception('ATMOrder: Ошибка записи и поиска имеющейся записи.');
				}
			}
			#Yii::info($rq->attributes, 'parse');

			$ast->Status = $fields['Status'];
			$ast->Date = Convert::Date2SQLiteDate($mail->PostedDate);
			#$ast->link('order', $atm);
			$ast->ATMOrderID = $atm->ID;
			$ast->save();

 			if (isset($fields['TNameCode']) && trim($fields['TNameCode']) !== '') {
				$tech->Code = strtolower($fields['TNameCode']);
				$tech->Name = $fields['TName'];
				$tech->save();
				
				$atc->Code = strtolower($fields['TNameCode']);
				$atc->Date = Convert::Date2SQLiteDate($mail->PostedDate);
				#$atc->link('order', $atm);
				$atc->ATMOrderID = $atm->ID;
				$atc->save();
			}

			foreach ($fields['NCRRemarks'] as $rem) {
				$are = new arATMOrderRemark();
				$are->attributes = $rem;
				$are->Text = trim(str_replace("\n", " ", $are->Text));
				$are->Date = Convert::Date2SQLiteDate($are->Date);
				#$are->link('order', $atm);
				$are->ATMOrderID = $atm->ID;
				$are->save();
			}
			$trans->commit();
		} catch (\Exception $e) {
			$trans->rollback();
			Yii::warning("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
			Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
			Yii::error([
				'arATMOrder', $atm->attributes,
				'arATMOrderStatus', $ast->attributes,
				'arATMOrderTech', $atc->attributes,
				], \app\models\api\MailAction::LOG_CATEGORY);
			throw new ServerErrorHttpException("ATMOrder: Ошибка записи в базу. " . Convert::Exception2Str($e));
		}
	}

}
