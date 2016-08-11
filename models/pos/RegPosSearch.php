<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\pos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of RegPosSearch
 *
 * @author proph
 */
class RegPosSearch extends arRegPos {

	public function rules() {
		return[
			[['TerminalID', 'Name', 'Address'], 'string'],
		];
	}

	public function search($param) {

		$query = arRegPos::find();
		#$query->with('texts');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => ['TerminalID' => SORT_ASC],
			],
		]);

		if (!($this->load($param) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'and',
			['like', 'TerminalID', $this->TerminalID],
			['like', 'Address', $this->Address],
			['like', 'Name', $this->Name],
		]);
		#var_dump($query->where);
		return $dataProvider;
	}

}
