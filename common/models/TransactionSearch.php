<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `backend\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'value'], 'integer'],
            [['purpose', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'value' => $this->value,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'purpose', $this->purpose]);

        return $dataProvider;
    }
}
