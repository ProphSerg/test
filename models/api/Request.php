<?php

namespace app\models\api;

use Yii;
use yii\base\Model;
use app\models\request\arRequest;
use app\models\request\arReqText;
use app\common\Convert;
use app\models\api\Mail;

class Request extends Model {

	public function save($fields, Mail $mail) {

		$trans = arRequest::getDb()->beginTransaction();
		try {
			#Yii::info(['Save!', 'mail', $mail], 'parse');
			$rq = new arRequest();
			$rq->attributes = $fields;
			$rq->{'Type'} = 0;
			$rq->Date = Convert::MailDate2SQLiteDate($rq->Date);
			if($rq->save() === false){
				if(($rq = arRequest::find()->Where(['Type' => 0, 'Number' => $fields['Number']])->one()) === null){
					throw new Exception('Ошибка записи и поиска имеющейся записи.');
				}
			}
			#Yii::info($rq->attributes, 'parse');

			$rt = new arReqText();
			$rt->attributes = $fields;
			$rt->Date = Convert::MailDate2SQLiteDate($mail->PostedDate);
			$rt->link('request', $rq);
			$trans->commit();
		} catch (\Exception $e) {
			$trans->rollback();
			Yii::warning("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
			Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
			Yii::error(['arRequest', $rq->attributes, 'arReqText', $rt->attributes], \app\models\api\MailAction::LOG_CATEGORY);
			throw new ServerErrorHttpException("Ошибка записи в базу. " . Convert::Exception2Str($e));
		}
	}

}
