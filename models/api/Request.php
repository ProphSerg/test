<?php

namespace app\models\api;

use Yii;
use yii\base\Model;
use app\models\request\arRequest;
use app\models\request\arReqText;
use app\common\toStr;

class Request extends Model {

	public function save($fields) {

		$trans = arRequest::getDb()->beginTransaction();
		try {
			#Yii::info("Save!", 'parse');
			$rq = new arRequest();
			$rq->attributes = $fields;
			$rq->{'Type'} = 0;
			$rq->save();
			#Yii::info($rq->attributes, 'parse');

			$rt = new arReqText();
			$rt->attributes = $fields;
			$rt->link('request', $rq);
			$trans->commit();
		} catch (\Exception $e) {
			$trans->rollback();
			Yii::warning("Ошибка записи в базу. " . toStr::Exception($e), \app\models\api\MailAction::LOG_CATEGORY);
			Yii::error("Ошибка записи в базу. " . toStr::Exception($e), \app\models\api\MailAction::LOG_CATEGORY);
			Yii::error(['arRequest', $rq->attributes, 'arReqText', $rt->attributes], \app\models\api\MailAction::LOG_CATEGORY);
			throw new ServerErrorHttpException("Ошибка записи в базу. " . toStr::Exception($e));
		}
	}

}
