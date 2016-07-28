<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrderTech".
 *
 * @property integer $ID
 * @property integer $ATMOrderID
 * @property string $Date
 * @property string $Code
 */
class arvATMOrderTech extends arATMOrderTech {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'vATMOrderTech';
	}

}
