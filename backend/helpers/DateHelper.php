<?php

namespace backend\helpers;

use yii\base\BaseObject;

class DateHelper extends BaseObject{

    /*
     * 两个时间戳转成dataRangePicker直接能用的格式
     * */
    public static function timestampToDRP($time_begin,$time_end){

        return date('Y-m-d H:i',$time_begin).' ~ '.date('Y-m-d H:i',$time_end);
    }
}