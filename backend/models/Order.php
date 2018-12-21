<?php

namespace backend\models;

use Yii;

class Order extends \common\models\Order
{

    /*
     * 查找所有超时未付款的订单
     * */
    public static function getPayTimeoutOrders(){

        $max_time = Settings::getAllSettings()[Settings::ORDER_WAIT_PAY_MAX_TIME];

        $orders = self::find()->where(['order_status' => self::ORDER_STATUS_NOT_EFFECT,
            'pay_status' => self::PAY_STATUS_WAIT_PAY])->andWhere([
            '<','order_time',time() - $max_time
        ])->all();
//        $model = $orders[0];
        foreach ($orders as $model){
            $model->pay_status = Order::PAY_STATUS_TIMEOUT;
            $model->save();
        }


    }

}
