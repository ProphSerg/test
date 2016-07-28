<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrderStatus".
 *
 * @property integer $ID
 * @property integer $ATMOrderID
 * @property string $Date
 * @property string $Status
 */
class arvATMOrderStatus extends arATMOrderStatus {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'vATMOrderStatus';
	}

}
