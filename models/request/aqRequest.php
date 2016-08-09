<?php

namespace app\models\request;

use app\common\Convert;

/**
 * This is the ActiveQuery class for [[arRequest]].
 *
 * @see arRequest
 */
class aqRequest extends \yii\db\ActiveQuery {

	public function getRequest($num, $type = 0) {
		return $this->andWhere(['Number' => $num, 'Type' => $type])->one();
	}

	public function getRequestID($id) {
		return $this->andWhere(['ID' => $id])->one();
	}

	public function actived() {
		return $this->andWhere(['DateClose' => null]);
	}

	public function closed() {
		return $this->andWhere(['not', ['DateClose' => null]]);
	}

	public function ReportClose($range) {
		return $this
				->select(['sprType.Name as typeName', 'count(*) as countType'])
				->joinWith('typeName')
				->andWhere([
					'between',
					'DateClose',
					Convert::Date2SQLiteDate($range['start']),
					Convert::Date2SQLiteDate($range['end'])
				])
				->groupBy('type')
		;
	}

	/**
	 * @inheritdoc
	 * @return arRequest[]|array
	 */
	public function all($db = null) {
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return arRequest|array|null
	 */
	public function one($db = null) {
		return parent::one($db);
	}

}
