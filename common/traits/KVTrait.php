<?php

namespace common\traits;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;


trait KVTrait
{

    /**
     * @brief 获取kv数组
     * @param $key
     * @param $value
     * @param $condition => ['where' => [], 'orderBy' => mixed ]
     *
     * @return  kv.array
     */
    public static function kv($key, $value, array $condition = [])
    {/*{{{*/

        $query = static::find()->select([$key, $value]);

        if (!empty($condition)) {

            foreach ($condition as $property => $v) {

                if ( ! method_exists($query, $property))
                    throw new InvalidConfigException(" {$query::className()} does not has property: {$property}");

                $query->$property($v);
            }

        }

        $raw = $query->asArray()->all();

        $value = empty($raw) ? [] : ArrayHelper::map($raw, $key, $value);

        return $value;
    }/*}}}*/
    /*
    * @return  k => v1-v2
     */
    public static function kv_v($key, $value1, $value2, array $condition = [])
    {/*{{{*/
        $query = static::find()->select([$key, $value1, $value2]);

        if (!empty($condition)) {

            foreach ($condition as $property => $v) {

                if ( ! method_exists($query, $property))
                    throw new InvalidConfigException(" {$query::className()} does not has property: {$property}");
                $query->$property($v);
            }
        }
        $raws = $query->asArray()->all();
        $value = [];
        foreach($raws as $row) {
            $value[$row[$key]] = $row[$value1].'-'.$row[$value2];
        }

        return $value;
    }/*}}}*/
}
