<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\request;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\request\arRequest;

/**
 * Description of RequestSearch
 *
 * @author proph
 */
class RequestSearch extends arRequest {

	public function rules() {
		return[
			[['Number'], 'integer'],
			[['Date', 'DateClose'], 'safe'],
			[['Desc', 'Name', 'Addr'], 'string'],
		];
	}

	public function scenarios() {
		return Model::scenarios();
	}

	public function search($param) {

		$query = arRequest::find();
		call_user_func([$query, Yii::$app->controller->action->id]);
		$query->with('texts');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'Date' => SORT_ASC,
				],
			],
		]);

		if (!($this->load($param) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'and',
			['like', 'Number', $this->Number],
			['like', 'Desc', $this->Desc],
			['like', 'Name', $this->Name],
			['like', 'Addr', $this->Addr],
			['strftime("%d/%m/%Y", Date, "localtime")' => $this->Date],
		]);
		#var_dump($query->where);
		return $dataProvider;
	}

}
