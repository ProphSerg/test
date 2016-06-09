<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrderTech".
 *
 * @property integer $ID
 * @property integer $ATMOrder_ID
 * @property string $Date
 * @property string $Code
 */
class arATMOrderTech extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'ATMOrderTech';
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
			[['ATMOrder_ID', 'Date', 'Code'], 'required'],
			[['ATMOrder_ID'], 'integer'],
			[['Date'], 'safe'],
			[['Code'], 'string'],
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
			'Date' => 'Date',
			'Code' => 'Code',
		];
	}

	/**
	 * @inheritdoc
	 * @return aqATMOrderTech the active query used by this AR class.
	 */
	public static function find() {
		return new aqATMOrderTech(get_called_class());
	}

	public function getOrder() {
		return $this->hasOne(arATMOrder::className(), ['ID' => 'ATMOrder_ID']);
	}

}
