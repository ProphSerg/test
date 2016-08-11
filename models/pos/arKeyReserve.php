<?php

namespace app\models\pos;

use Yii;

/**
 * This is the model class for table "KeyReserve".
 *
 * @property string $Number
 * @property string $Comment
 */
class arKeyReserve extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'KeyReserve';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb() {
		return Yii::$app->get('dbPos');
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['Number'], 'required'],
			[['Number', 'Comment'], 'string'],
			[['Number'], 'unique'],
			[['Number'], 'trim'],
			[['Number'], 'filter', 'filter' => 'strtoupper', 'skipOnArray' => true],
			[['Number'], 'match', 'pattern' => arKey::NUMBER_PATTERN],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'Number' => 'Номер ключа',
			'Comment' => 'Комментарий',
		];
	}

	/**
	 * @inheritdoc
	 * @return KeyReserveQuery the active query used by this AR class.
	 */
	public static function find() {
		return new aqKeyReserve(get_called_class());
	}

	public static function findReserve($keynum) {
		return self::find()->where(['Number' => $keynum])->one();
	}

	public static function EnterRange($keydate, $start, $end) {
		$trans = self::getDb()->beginTransaction();
		try {

			for ($i = $start; $i <= $end; $i++) {
				$kr = new arKeyReserve();
				$kr->Number = sprintf("%s_%s_%04d", arKey::NUMBER_PREFIX, $keydate, $i);
				$kr->validate() && $kr->save();
			}
			$trans->commit();

			return true;
		} catch (\Exception $e) {
			$trans->rollback();

			return false;
		}
	}

	public static function UpdateComment($keynum, $comment) {
		if (($kr = self::findReserve($keynum)) == null) {
			$kr = new arKeyReserve();
			$kr->Number = $keynum;
		}
		$kr->Comment = $comment;

		$kr->validate() && $kr->save();
	}

}
