<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\forms\OrderForm;
use Yii;

class OrderController extends \frontend\components\rest\Controller{

    public function verbs()
    {
        return [
            'create' => ['post']
        ];
    }

    /*
     *  用户提交订单
     * */
    public function actionCreateOrder($distributor_id = null){


        $rawParams = Yii::$app->getRequest()->post();
        $form = new OrderForm();
        $order = $form->prepare($rawParams);
        //判断是不是分销商 这个码是谁的?

        //创建订单

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
}