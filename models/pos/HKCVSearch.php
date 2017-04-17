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
class HKCVSearch extends arHKCV {

	public function rules() {
		return[
			[['KCV', 'Serial'], 'string'],
		];
	}

	public function search($param) {

		$query = arHKCV::find();
		#$query->with('texts');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'Serial' => SORT_ASC,
					'DateEnter' => SORT_DESC,
				],
			],
			/*
			  'pagination' => [
			  'pageSize' => 2,
			  ],
			 * 
			 */
		]);

		if (!($this->load($param) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'and',
			['like', 'Serial', $this->Serial],
			['like', 'KCV', $this->KCV],
		]);
		#var_dump($query->where);
		return $dataProvider;
	}

}
