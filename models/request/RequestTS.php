<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\request;

use app\common\Convert;

/**
 * Description of RequestTS
 *
 * @author proph
 */
class RequestTS extends arRequest {

	public $Text;

	public function rules() {
		return [
			[['Name', 'Desc', 'Text'], 'required'],
			[['Desc', 'Append', 'Contact', 'Name', 'Addr', 'Text'], 'string'],
		];
	}

	public function addReqTS() {
		$this->Type = arRequest::REQUEST_TS;
		$this->Number = arRequest::getNextNumber(arRequest::REQUEST_TS);
		$this->Date = Convert::SQLiteDateNow();

		$rt = new arReqText();
		$rt->Date = $this->Date;
		$rt->Text = $this->Text;

		$trans = self::getDb()->beginTransaction();
		try {
			if ($this->save() === false) {
				throw new Exception('Request: Ошибка записи новой заявки ТСП.');
			}
			#Yii::info($rq->attributes, 'parse');

			$rt->link('request', $this);
			$trans->commit();
		} catch (\Exception $e) {
			$trans->rollback();
			Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), 'request');
			Yii::error(['arRequest', $rq->attributes, 'arReqText', $rt->attributes], 'request');
			throw new ServerErrorHttpException("Request: Ошибка записи в базу. " . Convert::Exception2Str($e));
		}
	}

}
