<?php

namespace frontend\modules\v1\models;

use common\components\ResponseCode;
use yii\db\Exception;
use yii\web\HttpException;
use common\helpers\NumHelper;

class Order extends \frontend\models\Order{


    public function fields()
    {
        return [
            'id',
            'order_id',
            'order_time',
            'phone',
            'name',
            'content',
            'total_amount',
            'payment_amount',
            'pay_time',
            'order_status',
            'pay_status',
            'title' => function($model){
                return $model->goods->name;
            },
            'goods_id' => function($model){
                return $model->goods->goods_id;
            }
        ];
    }



    /*
     * 创建订单
     *
     * */
    public static function createOrder($user_id,$rawParams){

        $model = new self();
        $model->setAttributes([
            'order_id' => self::generateUniqueOrderId(),
            'order_use_code' => self::generateUniqueOrderUseId(),
            'user_id' => $user_id,
            'total_amount' => $rawParams['total_amount'],
            'payment_amount' => $rawParams['payment_amount'],
            'content' => $rawParams['content'],
            'phone' => $rawParams['phone'],
            'name' => $rawParams['name'],
            'goods_id' => $rawParams['goods_id'],
            'num' => $rawParams['num'],
            'pay_status' => self::PAY_STATUS_WAIT_PAY,
            'order_status' => self::ORDER_STATUS_NOT_EFFECT,
            'order_time' => time(),
        ]);

        if($model->save()){
            return $model;
        }

        throw new HttpException(403,'订单参数有误',ResponseCode::ORDER_PARAMS_ERROR);
    }

    /*
     * 查找一个用户某商品成功买了多少
     * */
    public static function getGoodsNum($user_id,$goods_id){

        return self::find()->where(['user_id' => $user_id,
            'goods_id' => $goods_id,
            'order_status' => self::ORDER_STATUS_NOT_USE,
            'pay_status' => self::PAY_STATUS_PAYED])
            ->count();
    }

    /*
     * 用户取消订单
     * */
    public static function cancelOrder(Order $model){
        if($model->order_status == self::ORDER_STATUS_NOT_EFFECT) {
            $model->order_status = self::ORDER_STATUS_CANCEL;
            $model->save();
        }else{
            throw new HttpException(403,'订单状态有误',ResponseCode::ORDER_STATUS_NOT_CORRECT);
        }
        return $model;
    }

    /*
     * 用户成功支付订单
     * */
    public static function payOrder(Order $model){

        $model->order_status = self::ORDER_STATUS_NOT_USE;
        $model->pay_status = self::PAY_STATUS_PAYED;
        $model->pay_time = time();
        $model->save();
        return $model;
    }

    /*
     * 生成订单号
     * */
    public static function generateUniqueOrderId(){

        return NumHelper::randNum(14);
    }

    /*
     * 生成订单使用码
     * */
    public static function generateUniqueOrderUseId(){

        return NumHelper::randNum(10);
    }

}