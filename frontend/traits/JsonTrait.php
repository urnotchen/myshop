<?php

namespace frontend\traits;

/**
 * JsonTrait trait file.
 * @Author haoliang
 * @Date 25.05.2016 11:45
 */
trait JsonTrait
{

    /**
     * @brief parseJson 
     *
     * todo 变更 model 返回exception.message变量类型
     *
     * @param $string
     *
     * @return string|array
     */
    protected function parseJson($string)
    {/*{{{*/

        if (! preg_match('/^(\[|{)/', $string))
            return $string;

        try {
            return \yii\helpers\Json::decode($string);
        } catch (\yii\base\InvalidParamException $e) {
            return $string;
        }

    }/*}}}*/

}
