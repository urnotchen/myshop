<?php

namespace common\traits;

use yii\helpers\ArrayHelper;


trait EnumTrait
{

    public static function enum($attr = null, $key = null)
    {/*{{{*/
        $enum = static::getEnumData();

        if (empty($enum))
            return null;

        if ($attr === null)
            return $enum;

        if (!isset($enum[$attr]))
            return null;

        if ($key === null)
            return $enum[$attr];

        return ArrayHelper::getValue($enum[$attr], $key);
    }/*}}}*/

    public static function getEnumData()
    {/*{{{*/
        return [];
    }/*}}}*/

}
