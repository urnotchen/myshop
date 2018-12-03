<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "distribution".
 *
 * @property int $id
 * @property string $distribution_id
 * @property string $goods_id
 * @property string $purchaser_id
 * @property string $distributor_id
 * @property string $prize
 * @property string $order_id
 * @property string $pay_time
 * @property string $use_time
 * @property int $created_at
 * @property int $updated_at
 */
class Distribution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distribution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distribution_id', 'goods_id', 'prize', 'created_at', 'updated_at'], 'required'],
            [['goods_id', 'purchaser_id', 'distributor_id', 'order_id', 'pay_time', 'use_time', 'created_at', 'updated_at'], 'integer'],
            [['prize'], 'number'],
            [['distribution_id'], 'string', 'max' => 255],
            [['distribution_id'], 'unique'],
            [['order_id'], 'unique'],
            [['pay_time'], 'unique'],
            [['use_time'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'distribution_id' => 'Distribution ID',
            'goods_id' => 'Goods ID',
            'purchaser_id' => 'Purchaser ID',
            'distributor_id' => 'Distributor ID',
            'prize' => 'Prize',
            'order_id' => 'Order ID',
            'pay_time' => 'Pay Time',
            'use_time' => 'Use Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
