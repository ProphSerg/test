<?php

namespace app\models\pos;

/**
 * This is the ActiveQuery class for [[RegPos]].
 *
 * @see RegPos
 */
class aqRegPos extends \yii\db\ActiveQuery {

	public function findReg($termID, $keyNum) {
		return $this->andWhere([
				'TerminalID' => $termID,
				'KeyNum' => strtoupper($keyNum),
		])->one();
	}

	/**
	 * @inheritdoc
	 * @return RegPos[]|array
	 */
	public function all($db = null) {
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return RegPos|array|null
	 */
	public function one($db = null) {
		return parent::one($db);
	}

}
