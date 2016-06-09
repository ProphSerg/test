<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\api;

use Yii;
use yii\web\ServerErrorHttpException;
use yii\base\Model;
use app\models\request\arRequest;
use app\models\request\arReqText;
use app\common\Convert;
use app\models\api\Mail;

/**
 * Description of RequestOver
 *
 * @author proph
 */
class RequestRecall extends Model {

	public function save($fields, Mail $mail) {

		if (preg_match('/recal.+?(\d+)/ui', $mail->Subject, $match) > 0) {
			if (($rq = arRequest::find()->getRequest($match[1])) !== null) {
				$trans = arRequest::getDb()->beginTransaction();
				try {
					$rq->DateClose = Convert::Date2SQLiteDate($mail->PostedDate);
					$rq->save();

					$rt = new arReqText();
					$rt->attributes = $fields;
					$rt->Date = Convert::Date2SQLiteDate($mail->PostedDate);
					$rt->link('request', $rq);
					$trans->commit();
				} catch (\Exception $e) {
					$trans->rollback();
					Yii::warning("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
					Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
					Yii::error(['arRequest', $rq->attributes, 'arReqText', $rt->attributes], \app\models\api\MailAction::LOG_CATEGORY);
					throw new ServerErrorHttpException("Request: Ошибка записи в базу. " . Convert::Exception2Str($e));
				}
			}
		}
	}

}
