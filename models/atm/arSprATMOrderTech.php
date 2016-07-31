<?php

namespace app\models\atm;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sprATMOrderTech".
 *
 * @property integer $ID
 * @property string $Code
 * @property string $Name
 * @property string $NameRus
 * @property string $Phone
 */
class arSprATMOrderTech extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'sprATMOrderTech';
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
			[['Code', 'Name'], 'required'],
			[['Code', 'Name', 'NameRus', 'Phone'], 'string'],
			[['Code'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'Code' => 'Code',
			'Name' => 'ФИО',
			'NameRus' => 'ФИО (рус)',
			'Phone' => 'Телефон',
		];
	}

	/**
	 * @inheritdoc
	 * @return SprATMOrderTechQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqSprATMOrderTech(get_called_class());
	}

	public static function getTechList() {
		$stl = arSprATMOrderTech::find()
			->select(['Code', 'Name'])
			->orderBy('Name')
			->all();

		return ArrayHelper::map($stl, 'Code', 'Name');
	}

}
