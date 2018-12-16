<?php

namespace backend\modules\order\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\order\models\Order;

/**
 * OrderSearch represents the model behind the search form of `backend\modules\order\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'user_id', 'num', 'order_time', 'pay_time', 'use_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['order_use_code', 'order_id'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

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
            'goods_id' => $this->goods_id,
            'user_id' => $this->user_id,
            'num' => $this->num,
            'order_time' => $this->order_time,
            'pay_time' => $this->pay_time,
            'use_time' => $this->use_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'order_use_code', $this->order_use_code])
            ->andFilterWhere(['like', 'order_id', $this->order_id]);

        return $dataProvider;
    }
}
