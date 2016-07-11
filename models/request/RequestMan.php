<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\request;

use app\common\Convert;
use app\models\atm\arSprATM;

/**
 * Description of RequestTS
 *
 * @author proph
 */
class RequestMan extends arRequest {

	public $Text;
	public $ATMID;

	public function rules() {
		if ($this->Type == arRequest::REQUEST_TS) {
			return [
				[['Name', 'Desc', 'Text'], 'required'],
				[['Desc', 'Append', 'Contact', 'Name', 'Addr', 'Text'], 'string'],
			];
		} elseif ($this->Type == arRequest::REQUEST_ATM) {
			return [
				[['ATMID', 'Text'], 'required'],
				[['ATMID'], 'integer'],
				[['Text'], 'string'],
			];
		}
	}

	public function addReq() {
		#$this->Type = arRequest::REQUEST_TS;
		$this->Number = arRequest::getNextNumber($this->Type);
		$this->Date = Convert::SQLiteDateNow();

		if ($this->Type == arRequest::REQUEST_ATM) {
			$atm = arSprATM::find()->byID($this->ATMID);
			if ($atm === null) {
				throw new Exception('Request: Ошибка выбора банкомата.');
			}
			#var_dump($atm);
			$this->Name = $atm->Type;
			$this->Desc = $atm->TerminalID;
			$this->Addr = $atm->Addres;
		}
		$rt = new arReqText();
		$rt->Date = $this->Date;
		$rt->Text = $this->Text;

		$trans = self::getDb()->beginTransaction();
		try {
			if ($this->save() === false) {
				throw new Exception('Request: Ошибка записи новой заявки.');
			}
			#Yii::info($rq->attributes, 'parse');

			$rt->link('request', $this);
			$trans->commit();
		} catch (\Exception $e) {
			$trans->rollback();
			Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), 'request');
			Yii::error(['arRequest', $this->attributes, 'arReqText', $rt->attributes], 'request');
			throw new ServerErrorHttpException("Request: Ошибка записи в базу. " . Convert::Exception2Str($e));
		}
	}

}
