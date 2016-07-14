<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "ATMOrderRemark".
 *
 * @property integer $ID
 * @property integer $ATMOrder_ID
 * @property string $Date
 * @property string $Creater
 * @property integer $Text
 */
class arATMOrderRemark extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'ATMOrderRemark';
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
			[['ATMOrder_ID', 'Date', 'Autor', 'Text'], 'required'],
			[['ATMOrder_ID'], 'integer'],
			[['Date'], 'safe'],
			[['Autor', 'Text'], 'string'],
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
			'Creater' => 'Автор',
			'Text' => 'Сообщение',
		];
	}

	/**
	 * @inheritdoc
	 * @return ATMOrderRemarkQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqATMOrderRemark(get_called_class());
	}

	public function getOrder() {
		return $this->hasOne(arATMOrder::className(), ['ID' => 'ATMOrder_ID']);
	}

}
