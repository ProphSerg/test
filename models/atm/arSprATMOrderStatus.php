<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "sprATMOrderStatus".
 *
 * @property integer $ID
 * @property string $StatusID
 * @property string $StatusName
 */
class arSprATMOrderStatus extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'sprATMOrderStatus';
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
			[['StatusID', 'StatusName'], 'required'],
			[['StatusID', 'StatusName'], 'string'],
			[['StatusID'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'StatusID' => 'Status ID',
			'StatusName' => 'Статус',
		];
	}

	/**
	 * @inheritdoc
	 * @return SprATMOrderStatusQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqSprATMOrderStatus(get_called_class());
	}

}
