<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * ExistValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 11:52
 */
class ExistValidator extends \yii\validators\ExistValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::EXIST;
        }
    }/*}}}*/
}
