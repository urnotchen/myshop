<?php

namespace frontend\modules\v1\models;

use common\components\ResponseCode;
use yii\db\Exception;
use yii\web\HttpException;
use common\helpers\NumHelper;

class Order extends \frontend\models\Order{

    /*
     * 创建订单
     *
     * */
    public static function createOrder($user_id,$rawParams){

        $model = new self();
        $model->setAttributes([
            'order_id' => self::generateUniqueOrderId(),
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
        var_dump($model->save());die;
        if($model->save()){echo 1;die;
            return $model->attributes['id'];
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

    public static function generateUniqueOrderId(){

        return NumHelper::randNum(14);
    }
}