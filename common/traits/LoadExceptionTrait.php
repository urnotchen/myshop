<?php

namespace common\traits;

trait LoadExceptionTrait
{

    /**
     * @brief 父类同名方法返回false时此处将直接抛出HttpException
     *
     * @param $data
     * @param $formName
     *
     * @return boolean
     * @throw HttpException
     */
    public function load($data, $formName = null)
    {/*{{{*/
        if ( ! parent::load($data, $formName)) {
            throw new \yii\web\HttpException(
                400,
                'nothing in request',
                \common\components\ResponseCode::REQUEST_PARAMS_VALIDATE_FAILED
            );
        }

        return true;
    }/*}}}*/

}
