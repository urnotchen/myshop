<?php

namespace backend\controllers;

use backend\models\Order;
use yii\web\Controller;

class ApiController extends Controller{

    /*
     * 如果到时还未付款，订单状态改为超时
     * */
    public function actionOrderTimeout(){

        //查找所有超时订单 统一更改状态
        $orders = Order::getPayTimeoutOrders();

    }
}