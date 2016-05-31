<?php

namespace app\models\api;

use Yii;
use yii\base\Model;
use app\models\request\arRequest;

class Request extends Model {

	private $AR;

	public function __construct() {
		$this->AR = new arRequest();
		parent::__construct();
	}

	public function SetField($field, $val) {
		if ($field == 'Text') {
			
		} else {
		Yii::info("SetField ($field => $val)", 'parse');
			$this->AR->{$field} = $val;
		}
	}

	public function save() {
		Yii::info("Save!", 'parse');
		$this->AR->Type = 0;
		$this->AR->save();
	}

	public static function import(\app\models\api\Mail $mail) {
		echo "RUN " . __CLASS__ . ", Metod: " . __METHOD__ . "\n";

		return true;
	}

}
