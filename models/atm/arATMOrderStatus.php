<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrderStatus".
 *
 * @property integer $ID
 * @property integer $ATMOrder_ID
 * @property string $Date
 * @property string $Status
 */
class arATMOrderStatus extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'ATMOrderStatus';
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
			[['ATMOrder_ID', 'Date', 'Status'], 'required'],
			[['ATMOrder_ID'], 'integer'],
			[['Date'], 'safe'],
			[['Status'], 'string'],
			#[['ATMOrder_ID', 'Date'], 'unique'],
			[['ATMOrder_ID', 'Date'], 'unique', 'targetAttribute' => ['ATMOrder_ID', 'Date'], 'message' => 'The combination of Atmorder  ID and Date has already been taken.'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'ATMOrder_ID' => 'Atmorder  ID',
			'Date' => 'Дата',
			'Status' => 'Статус',
		];
	}

	/**
	 * @inheritdoc
	 * @return ATMOrderStatusQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqATMOrderStatus(get_called_class());
	}

	public function getOrder() {
		return $this->hasOne(arATMOrder::className(), ['ID' => 'ATMOrder_ID']);
	}

	public function getStatusName() {
		return $this->hasOne(arSprATMOrderStatus::className(), ['StatusID' => 'Status']);
	}

}
