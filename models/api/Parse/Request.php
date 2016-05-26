<?php

namespace app\models\api\Parse;

use yii\base\Model;

class Request extends Model {

	public static function import(\app\models\api\Mail $mail) {
		echo "RUN " . __CLASS__ . ", Metod: " . __METHOD__ . "\n";

		return true;
	}

}
