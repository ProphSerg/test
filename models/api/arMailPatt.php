<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "MailPatt".
 *
 * @property integer $ID
 * @property string $Pattern
 * @property string $BodyPattern
 */
class arMailPatt extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'MailPatt';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb() {
		return Yii::$app->get('dbSys');
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['Pattern', 'BodyPattern', 'Model'], 'required'],
			[['Pattern', 'BodyPattern', 'Model'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'Pattern' => 'Pattern',
			'BodyPattern' => 'Body Pattern',
			'Model' => 'Model',
		];
	}

	/**
	 * @inheritdoc
	 * @return aqMailPatt the active query used by this AR class.
	 */
	public static function find() {
		return new aqMailPatt(get_called_class());
	}

	public function getBodyPatt() {
		return $this->hasMany(arBodyPatt::className(), ['name' => 'BodyPattern'])
				->orderBy('Priority');
	}

}
