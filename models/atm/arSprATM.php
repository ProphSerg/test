<?php

namespace app\models\atm;

use Yii;

/**
 * This is the model class for table "sprATM".
 *
 * @property integer $ID
 * @property string $Model
 * @property string $Serial
 * @property string $TerminalID
 * @property string $Addres
 * @property string $Type
 */
class arSprATM extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'sprATM';
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
			[['Model', 'Serial', 'Addres'], 'required'],
			[['Model', 'Serial', 'TerminalID', 'Addres', 'Type', 'InvNum'], 'string'],
			[['Serial'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'Model' => 'Модель',
			'Serial' => 'Серийный №',
			'TerminalID' => 'TerminalID',
			'Addres' => 'Адрес ',
			'Type' => 'Тип',
			'InvNum' => 'Инв. №'
		];
	}

	/**
	 * @inheritdoc
	 * @return SprATMQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqSprATM(get_called_class());
	}

	public function getOrder() {
		return $this->hasMany(arATMOrder::className(), ['Serial' => 'Serial']);
	}

	public function getFullName() {
		return $this->TerminalID . ' ' . $this->Addres;
	}

}
