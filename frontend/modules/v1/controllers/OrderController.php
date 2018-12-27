<?php

namespace frontend\modules\v1\controllers;

use common\components\ResponseCode;
use frontend\modules\v1\models\Distribution;
use frontend\modules\v1\models\forms\OrderForm;
use frontend\modules\v1\models\FUser;
use frontend\modules\v1\models\Goods;
use frontend\modules\v1\models\Order;
use Yii;
use yii\db\Exception;
use yii\web\HttpException;

class OrderController extends \frontend\components\rest\Controller{

    public function verbs()
    {
        return [
            'create' => ['post']
        ];
    }

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'create-order','cancel-order'
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];

        return $inherit;
    }

    /*
     *  用户提交订单
     * */
    public function actionCreateOrder(){

        $rawParams = Yii::$app->getRequest()->post();
        $form = new OrderForm();
        $form->prepare($rawParams);
        //判断是不是分销商 这个码是谁的?
        $fuser_id = $this->getUser()->id;
        $goods = Goods::findOneOrException(['goods_id' => $rawParams['goods_id']]);
        $rawParams['goods_id'] = $goods->id;
        $transaction = Yii::$app->db->beginTransaction();
        try{
            Goods::reduceInventory($rawParams['goods_id'],$rawParams['num']);
            $order = Order::createOrder($fuser_id,$rawParams);//$rawParams['num'],$rawParams['goods_id'],$rawParams['name'],$rawParams['phone'],$rawParams['content']);
            //Goods减少库存
            if($distributor = FUser::isDistributor($rawParams['distributor_id'])){
                //是分销商 分销商数据要写入表中 付款的时候要算提成

                //写入分销表
                $distribution_id = Distribution::create($fuser_id,$rawParams['goods_id'],$distributor->id,$goods->distributor_prize,$order->id);
                $order->distribution_id = $distribution_id;
                $order->distributor_id = $distributor->id;
                $order->save();
            }
        }catch (\Exception $e) {
            var_dump($e->getMessage());die;
            return $e->getMessage();
            throw new HttpException(403,'数据库错误',ResponseCode::DATABASE_SAVE_FAILED);
        }
        $transaction->commit();
    //创建订单 model里的方法

        //
        return $order;

    }

    /*
     * 取消订单
     * */
    public function actionCancelOrder(){

        //order表更改状态
        $rawParams = Yii::$app->getRequest()->post();

        $order = Order::findOneOrException(['order_id' => $rawParams['id']]);
        if($order->user_id != $this->getUser()->id){
            throw new HttpException(403,'用户无权操作',ResponseCode::USER_ACCESS_FORBIDDEN);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $order = Order::cancelOrder($order);
            //如果也有distribution 也更改状态
            if ($order->distribution_id) {
                Distribution::cancelDistribution($order->id);
            }
            //修改库存量
            Goods::increseInventory($order->goods_id, $order->num);
        }catch (\Exception $e) {
            $transaction->rollback();
            throw new HttpException(403,'订单修改失败 请刷新重试',ResponseCode::DATABASE_SAVE_FAILED);
        }
        $transaction->commit();
        return $order;
    }

    /*
     * 用户支付
     * */
    public function actionPayOrder(){

        $rawParams = Yii::$app->getRequest()->post();

        //todo 支付验证 校验参数

        $order = Order::findOneOrException(['order_id' => $rawParams['id']]);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            //成功,修改order表状态
            $order = Order::payOrder($order);

            if($order->distribution_id) {
                //如果有分销,修改distribution表状态
                $distributor = Distribution::payDistribution($order->id);
                //用户表 增加金额
                FUser::addDistributorPrize($order->distributor_id, $distributor->prize);
            }
        }catch (\Exception $e) {
            $transaction->rollback();
            throw new HttpException(403,'支付成功 数据库存入失败 请刷新重试',ResponseCode::DATABASE_SAVE_FAILED);
        }
        $transaction->commit();
        return $order;
    }

    /*
     * 主页列表显示 timeline
     * */
    public function actionIndex(){


    }


}