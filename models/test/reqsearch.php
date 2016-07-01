<?php

namespace app\models\test;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\request\arRequest;

/**
 * reqsearch represents the model behind the search form about `app\models\request\arRequest`.
 */
class reqsearch extends arRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'Type', 'Number'], 'integer'],
            [['Date', 'DateClose', 'Desc', 'Append', 'Contact', 'Name', 'Addr'], 'safe'],
            [['Overdue'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = arRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'Type' => $this->Type,
            'Number' => $this->Number,
            'Date' => $this->Date,
            'DateClose' => $this->DateClose,
            'Overdue' => $this->Overdue,
        ]);

        $query->andFilterWhere(['like', 'Desc', $this->Desc])
            ->andFilterWhere(['like', 'Append', $this->Append])
            ->andFilterWhere(['like', 'Contact', $this->Contact])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Addr', $this->Addr]);

        return $dataProvider;
    }
}
