<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Goods;

/**
 * GoodsSearch represents the model behind the search form of `frontend\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'is_delete', 'sales_begin', 'sales_end', 'stock_num', 'store_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'sales_num'], 'integer'],
            [['goods_id', 'name', 'content', 'email'], 'safe'],
            [['distributor_prize', 'sales_initial', 'sales_actual'], 'number'],
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
        $query = Goods::find();

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
            'distributor_prize' => $this->distributor_prize,
            'sales_initial' => $this->sales_initial,
            'sales_actual' => $this->sales_actual,
            'status' => $this->status,
            'is_delete' => $this->is_delete,
            'sales_begin' => $this->sales_begin,
            'sales_end' => $this->sales_end,
            'stock_num' => $this->stock_num,
            'store_id' => $this->store_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'sales_num' => $this->sales_num,
        ]);

        $query->andFilterWhere(['like', 'goods_id', $this->goods_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
