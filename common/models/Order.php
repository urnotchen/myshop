<?php

namespace common\models;

use backend\behaviors\AutoChangeDistributionStatusBehavior;
use common\traits\FindOrExceptionTrait;
use common\traits\SaveExceptionTrait;
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
    use SaveExceptionTrait;
    use FindOrExceptionTrait;

    //付款状态 待付,已付,付款超时
    const PAY_STATUS_WAIT_PAY = 1,PAY_STATUS_PAYED = 2,PAY_STATUS_TIMEOUT = 3;

    //订单状态 无效 订单取消 未使用 已使用
    const ORDER_STATUS_NOT_EFFECT = 1,ORDER_STATUS_CANCEL = 2,ORDER_STATUS_NOT_USE = 3,ORDER_STATUS_USED = 4;

    public function behaviors()
    {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
            'auto_change_distribution_status' => [
                'class' => AutoChangeDistributionStatusBehavior::className(),
                'order' => $this
            ]
        ];
    }
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
            [['order_id', 'goods_id', 'name','phone','num','pay_status', 'order_status'], 'required'],
            [['goods_id','distributor_id','distribution_id', 'user_id', 'num', 'order_time', 'pay_time', 'use_time','pay_status', 'order_status', 'updated_by','created_at', 'updated_at'], 'integer'],
            [['order_use_code','content', 'order_id'], 'string', 'max' => 255],
            [['total_amount','payment_amount'],'number'],
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
    public function getGoods(){

        return $this->hasOne(Goods::className(),['id' => 'goods_id']);
    }
}
