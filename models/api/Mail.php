<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\api;

use yii\base\Model;

class Mail extends Model {
	private $_attr = [];

	public function __get($param) {
		if (array_key_exists($param, $this->_attr))
			return $this->_attr[$param];

		return null;
	}

	public function __set($name, $value) {
		$this->_attr[$name] = $value;
	}

	public function __isset($param) {
		return isset($this->_attr[$param]);
	}

	public function __unset($param) {
		unset($this->_attr[$param]);
	}

	public function fields() {
		return [
			'From',
			'SendTo',
			'CopyTo',
			'Subject',
			'Body',
		];
	}

}
