<?php

namespace backend\behaviors;

use backend\models\Distribution;
use backend\models\Order;
use yii\base\Behavior;

class AutoChangeDistributionStatusBehavior extends Behavior{

    public $order;

    public function events()
    {
        return [Order::EVENT_AFTER_UPDATE => 'afterUpdate'];
    }

    public function afterUpdate($event){

        if($this->order->pay_status == Order::PAY_STATUS_TIMEOUT){

            Distribution::toTimeout($this->order->distribution_id);
        }
    }

}