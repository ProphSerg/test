<?php

namespace app\models\api;

use Yii;
use yii\web\ServerErrorHttpException;
use yii\base\Model;
use app\common\Convert;
use app\models\api\Mail;
use app\models\pos\arRegPos;

class RegPos extends Model {

	public function save($fields, Mail $mail) {
		#Yii::info(['RegPos Save!', 'fields', $fields], 'parse');
		#return;
		$ex = '';
		foreach ($fields['RegPos'] as $frp) {
			$trans = arRegPos::getDb()->beginTransaction();
			try {
				#Yii::info(['Save!', 'mail', $mail], 'parse');
				$rp = arRegPos::find()->findReg($frp['TerminalID'], $frp['KeyNum']);
				if ($rp == null) {
					$rp = new arRegPos();
				}
				$rp->attributes = $frp;
				$rp->DateReg = Convert::Date2SQLiteDate($mail->PostedDate);
				if ($rp->save() === false) {
					throw new \Exception('RegPos: Ошибка записи [' . Convert::ValidaterError2Str($rp) . ']');
				}
				$trans->commit();
			} catch (\Exception $e) {
				$trans->rollback();
				Yii::warning("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
				Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
				Yii::error(['arRegPos', $rp->attributes], \app\models\api\MailAction::LOG_CATEGORY);
				$ex = implode('\n', [$ex, "RegPos: Ошибка записи в базу. " . Convert::Exception2Str($e)]);
			}
		}
		if ($ex != '') {
			throw new ServerErrorHttpException($ex);
		}
	}

}
