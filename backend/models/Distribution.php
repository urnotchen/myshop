<?php

namespace backend\models;

use Yii;

class Distribution extends \common\models\Distribution
{

    /*
     * 状态改为超时
     * */
    public static function toTimeout($distribution_id){

        $distribution = self::findOneOrException(['id' => $distribution_id]);

        $distribution->status = self::STATUS_TIMEOUT;
        $distribution->save();
    }
}
