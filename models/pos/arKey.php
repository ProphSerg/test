<?php

namespace app\models\pos;

use Yii;
use app\common\KeyCheck;

/**
 * This is the model class for table "key".
 *
 * @property string $Number
 * @property string $Comp1
 * @property string $Comp2
 * @property string $Comp3
 */
class arKey extends \yii\db\ActiveRecord {

	public $Check;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'key';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb() {
		return Yii::$app->get('dbKey');
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['Number', 'Comp1', 'Comp2', 'Comp3'], 'required'],
			[['Number', 'Comp1', 'Comp2', 'Comp3', 'Check'], 'string'],
			[['Number'], 'unique'],
			[['Number', 'Comp1', 'Comp2', 'Comp3', 'Check'], 'trim'],
			[['Number', 'Comp1', 'Comp2', 'Comp3', 'Check'], 'filter', 'filter' => 'strtoupper', 'skipOnArray' => true],
			[['Number'], 'match', 'pattern' => '/^O\d{2}S2_\d{6}_\d{4}$/s'],
			[['Comp1', 'Comp2', 'Comp3'], 'match', 'pattern' => '/^[0-9A-F]{32}$/s'],
			[['Check'], 'validateCheckKCV'],
		];
	}

	public function validateCheckKCV($attribute, $params) {
		if (!$this->hasErrors() && !empty($this->$attribute) &&
			($this->$attribute != KeyCheck::FullKeyKCV($this->Comp1, $this->Comp2, $this->Comp3))) {
			$this->addError($attribute, 'Контрольная сумма не совподает с введенными ключами');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'Number' => 'Номер ключа',
			'Comp1' => 'Компонента 1',
			'Comp2' => 'Компонента 2',
			'Comp3' => 'Компонента 3',
			'Check' => 'Контрольная сумма (KCV)'
		];
	}

	/**
	 * @inheritdoc
	 * @return aqKey the active query used by this AR class.
	 */
	public static function find() {
		return new aqKey(get_called_class());
	}

	public static function isExist() {
		try {
			self::getTableSchema();
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}

}
