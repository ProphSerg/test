<?php

namespace app\models\api;

use yii\base\Model;
use app\models\request\arRequest;

class Request extends Model {

    private $AR;

    public function __construct() {
	$AR = new arRequest();
	parent::__construct();
    }

    public function SetField($field, $val) {
	$AR->$field = $val;
    }

    public function save() {
	$AR->Type = 0;
	$AR->save();
    }

    public static function import(\app\models\api\Mail $mail) {
	echo "RUN " . __CLASS__ . ", Metod: " . __METHOD__ . "\n";

	return true;
    }

}
