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
			[['ATMOrderID', 'Date', 'Code'], 'required'],
			[['ATMOrderID'], 'integer'],
			[['Date'], 'safe'],
			[['Code'], 'string'],
			[['ATMOrderID', 'Date'], 'unique', 'targetAttribute' => ['ATMOrderID', 'Date'], 'message' => 'The combination of Atmorder  ID and Date has already been taken.'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'ATMOrderID' => 'Atmorder  ID',
			'Date' => 'Дата',
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
		return $this->hasOne(arATMOrder::className(), ['ID' => 'ATMOrderID']);
	}

	public function getTechName() {
		return $this->hasOne(arSprATMOrderTech::className(), ['Code' => 'Code']);
	}

}
