<?php

namespace frontend\modules\v1\models;

class Goods extends \frontend\models\Goods{


    public function fields()
    {
        return [
            'id',
            'goods_id',
            'name',
            'content',
            'distributor_prize',
            'sales_initial',
            'sales_actual',
            'goods_status',
            'sale_status',
            'sales_begin',
            'sales_end',
            'stock_num',
            'sales_num',
            'image_url',
            'max_num',
            'sales_begin',
            'sales_end',
        ];
    }

    public function extraFields()
    {
        return [
            'store'
        ];
    }

    public static function getGoodsDetails($id){

        $model = self::findOneOrException(['goods_id' => $id]);
        if($model){
            return $model->content;
        }
    }

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