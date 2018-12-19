<?php

namespace common\traits;

use Yii;

trait SaveExceptionTrait
{

    /**
     * @brief 父类同名方法返回false时此处将直接抛出HttpException
     *
     * @param $runValidation
     * @param $attributeNames
     *
     * @return boolean
     * @throw HttpException
     */
    public function save($runValidation = true, $attributeNames = null)
    {/*{{{*/
        $result = parent::save($runValidation, $attributeNames);

        if ($result === false)
            throw new \yii\web\HttpException(
                500,
                'save failed',
                \common\components\ResponseCode::PERSIST_DATA_ERROR
            );

        return $result;
    }/*}}}*/

}

