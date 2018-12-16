<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/*
 * 直接抛出,不走module设置的返回格式
 * 只针对用户登录
 * ios的需求:只返回一个code,不要错误数组
 * */
class SpeRequiredValidator extends \yii\validators\RequiredValidator
{

    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

//        $res = self::validate($this);
//        //如果为空 就抛出异常
//        if (!$res) {
//            throw new \yii\web\HttpException(
//                401,
//                '用户密码不匹配',
//                \common\components\ValidateErrorCode::PASSWORD_NOT_MATCH
//            );
//        }
    }/*}}}*/

    public function validateAttribute($model, $attribute)
    {
        $result = $this->validateValue($model->$attribute);
        if (!empty($result)) {
            throw new \yii\web\HttpException(
                401,
                '用户密码不匹配',
                \common\components\ValidateErrorCode::PASSWORD_NOT_MATCH
            );
        }
    }

}
