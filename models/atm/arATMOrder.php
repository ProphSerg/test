<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrder".
 *
 * @property integer $ID
 * @property string $Number
 * @property string $EnterDate
 * @property string $EnterBy
 * @property string $Serial
 *
 * */
class arATMOrder extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'ATMOrder';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb() {
		return Yii::$app->get('dbATM');
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['Number', 'EnterDate', 'EnterBy', 'Serial'], 'required'],
			[['Number', 'EnterBy', 'Serial'], 'string'],
			[['EnterDate'], 'safe'],
			[['Number'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'Number' => 'Номер заявки',
			'EnterDate' => 'Дата заявки',
			'EnterBy' => 'Enter By',
			'Serial' => 'Серийный №',
		];
	}

	/**
	 * @inheritdoc
	 * @return ATMOrderQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqATMOrder(get_called_class());
	}

	public function getStatus() {
		return $this->hasMany(arATMOrderStatus::className(), ['ATMOrder_ID' => 'ID']);
	}

	public function getStatusName() {
		return $this->hasOne(arSprATMOrderStatus::className(), ['StatusID' => 'Status'])
				->via('status');
	}

	public function getStatusLast() {
		return $this->hasOne(arATMOrderStatus::className(), ['ATMOrder_ID' => 'ID'])
				->orderBy(['ATMOrderStatus.Date' => SORT_DESC]);
	}

	public function getStatusNameLast() {
		return $this->hasOne(arSprATMOrderStatus::className(), ['StatusID' => 'Status'])
				->via('statusLast');
	}

	public function getTech() {
		return $this->hasMany(arATMOrderTech::className(), ['ATMOrder_ID' => 'ID']);
	}

	public function getTechLast() {
		return $this->hasOne(arATMOrderTech::className(), ['ATMOrder_ID' => 'ID'])
				->orderBy(['Date' => SORT_DESC]);
	}

	public function getRemarks() {
		return $this->hasMany(arATMOrderRemark::className(), ['ATMOrder_ID' => 'ID'])
				->orderBy('Date');
	}

	public function getSerial() {
		return $this->hasOne(arSprATM::className(), ['Serial' => 'Serial']);
	}

}
