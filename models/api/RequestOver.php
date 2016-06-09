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
use app\common\Convert;
use app\models\api\Mail;

/**
 * Description of RequestOver
 *
 * @author proph
 */
class RequestOver extends Model {

	public function save($fields, Mail $mail) {

		foreach ($fields['ReqOverNum'] as $rom) {
			if ( ($rq = arRequest::find()->getRequest($rom['ReqOverNum'])) !== null) {
				$rq->Overdue = 1;
				if ($rq->save() === false) {
					Yii::warning("Ошибка обновления заявки №{$rom['ReqOverNum']}", \app\models\api\MailAction::LOG_CATEGORY);
					Yii::error("Ошибка обновления заявки №{$rom['ReqOverNum']}", \app\models\api\MailAction::LOG_CATEGORY);
					Yii::error($rq->getErrors(), \app\models\api\MailAction::LOG_CATEGORY);
				}
			}
		}
	}

}
