<?php

namespace frontend\modules\v1\models;

class Order extends \frontend\models\Order{

    /*
     * 创建订单
     *
     * */
    public static function createOrder($user_id,$num,$goods_id,$name,$phone,$content = ''){

        $model = new self();
        $model->user_id = $user_id;
        $model->goods_id = $goods_id;
        $model->num = $num;
        $model->name = $name;
        $model->phone = $phone;
        $model->content = $content;

        return $model->save();
    }
}