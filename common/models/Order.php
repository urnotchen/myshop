<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $order_use_code
 * @property string $order_id
 * @property string $goods_id
 * @property string $user_id
 * @property int $num
 * @property string $order_time
 * @property string $pay_time
 * @property string $use_time
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'name','phone','content','num'], 'required'],
            [['goods_id', 'user_id', 'num', 'order_time', 'pay_time', 'use_time', 'status', 'updated_by','created_at', 'updated_at'], 'integer'],
            [['order_use_code', 'order_id'], 'string', 'max' => 255],
            [['order_use_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_use_code' => 'Order Use Code',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'user_id' => 'User ID',
            'num' => 'Num',
            'content' => 'content',
            'phone' => 'phone',
            'name' => 'name',
            'order_time' => 'Order Time',
            'pay_time' => 'Pay Time',
            'use_time' => 'Use Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}