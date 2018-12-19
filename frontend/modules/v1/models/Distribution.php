<?php
namespace frontend\modules\v1\models;

class Distribution extends \frontend\models\Distribution{

    /*
     * 用户提交订单(未付款)写入分销表
     * */
    public static function create($fuser_id,$goods_id,$distributor_id,$prize,$order_id){

        $distribution = new self();
        $distribution->goods_id = $goods_id;
        $distribution->purchaser_id = $fuser_id;
        $distribution->prize = $prize;
        $distribution->order_id = $order_id;
        $distribution->distribution_id = $distributor_id;

        return $distribution->save();
    }
}