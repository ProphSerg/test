<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\atm;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\atm\arATMOrder;

/**
 * Description of RequestSearch
 *
 * @author proph
 */
class ATMOrderSearch extends arATMOrder {

	public function rules() {
		return[
			[['Number', 'Serial'], 'string'],
			[['EnterDate'], 'safe'],
		];
	}

	public function scenarios() {
		return Model::scenarios();
	}

	public function search($param) {

		$query = arATMOrder::find();
		$query->with('statusLast')
			->with('techLast')
			->with('serial');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'EnterDate' => SORT_DESC,
				],
			],
		]);

		if (!($this->load($param) && $this->validate())) {
			return $dataProvider;
		}
		/*
		  $query->andFilterWhere([
		  'and',
		  ['like', 'Number', $this->Number],
		  ['like', 'Desc', $this->Desc],
		  ['like', 'Name', $this->Name],
		  ['like', 'Addr', $this->Addr],
		  ['strftime("%d/%m/%Y", Date, "localtime")' => $this->Date],
		  ]);
		  #var_dump($query->where);
		 */
		return $dataProvider;
	}

}
