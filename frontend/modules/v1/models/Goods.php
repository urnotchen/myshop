<?php

namespace frontend\modules\v1\models;

class Goods extends \frontend\models\Goods{


    /*
     * 用户下订单后减少库存
     * */
    public static function reduceInventory($goods_id,$num){

        $model = self::findOneOrException(['id' => $goods_id]);
        $model->stock_num -= $num;
        $model->sales_num += $num;
        $model->save();
        return $model;
    }

    /*
     * 用户取消订单修改库存
     * */
    public static function increseInventory($goods_id,$num){

        $model = self::findOneOrException(['id' => $goods_id]);
        $model->stock_num += $num;
        $model->sales_num -= $num;
        $model->save();
    }
}