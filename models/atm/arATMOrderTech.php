<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrderTech".
 *
 * @property integer $ID
 * @property integer $ATMOrder_ID
 * @property string $Code
 * @property string $Name
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
			[['ATMOrder_ID', 'Date, Code', 'Name'], 'required'],
			[['ATMOrder_ID'], 'integer'],
			[['Date'], 'safe'],
			[['Code', 'Name'], 'string'],
			[['ATMOrder_ID', 'Date'], 'unique'],
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
			'Name' => 'Name',
		];
	}

	/**
	 * @inheritdoc
	 * @return ATMOrderTechQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqATMOrderTech(get_called_class());
	}

	public function getOrder() {
		return $this->hasOne(arATMOrder::className(), ['ID' => 'ATMOrder_ID']);
	}

}
