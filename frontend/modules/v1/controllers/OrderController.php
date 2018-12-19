<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\Distribution;
use frontend\modules\v1\models\forms\OrderForm;
use frontend\modules\v1\models\FUser;
use frontend\modules\v1\models\Order;
use Yii;
use yii\db\Exception;

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
            'create-order'
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];

        return $inherit;
    }

    /*
     *  用户提交订单
     * */
    public function actionCreateOrder($distributor_id = null){



        $rawParams = Yii::$app->getRequest()->post();
        $form = new OrderForm();
        $form->prepare($rawParams);
        //判断是不是分销商 这个码是谁的?
        $fuser_id = $this->getUser()->id;
        $order_id = Order::createOrder($fuser_id,$rawParams);//$rawParams['num'],$rawParams['goods_id'],$rawParams['name'],$rawParams['phone'],$rawParams['content']);
die;
        if(FUser::isDistributor($distributor_id) == True){
            //是分销商 分销商数据要写入表中 付款的时候要算提成
            //写入分销表
            try{
                $distribution_id = Distribution::create($fuser_id,$rawParams['goods_id'],$distributor_id,$rawParams['prize'],$order_id);

            }catch (Exception $e){

            }
        }
        //创建订单 model里的方法

        //
        return 1;

    }

    /*
     * 取消订单
     * */
    public function actionCancelOrder(){


    }

    /*
     * 用户支付
     * */
    public function actionPayOrder(){

    }

    /*
     *
     * */

    public function actionIndex(){}
}