<?php
namespace frontend\modules\v1\models;

use common\components\ResponseCode;
use yii\web\HttpException;

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
        $distribution->distribution_id = self::generateUniqueDistributionId();
        $distribution->distributor_id = $distributor_id;
        $distribution->status = self::STATUS_WAIT_PAY;

        if($distribution->save()){
            return $distribution->attributes['id'];
        }
        var_dump($distribution->getErrors());die;
        throw new HttpException(403,'订单参数有误',ResponseCode::ORDER_PARAMS_ERROR);
    }

    /*
     * 取消订单
     * */
    public static function cancelDistribution($order_id){

        $model = self::findOneOrException(['order_id' => $order_id]);

        $model->status = self::STATUS_CANCEL;

        $model->save();
    }

    /*
     * 支付订单成功
     * */
    public static function payDistribution($order_id){

        $model = self::findOneOrException(['order_id' => $order_id]);

        $model->status = self::STATUS_PAYED;
        $model->pay_time = time();
        $model->save();

        return $model;
    }
}