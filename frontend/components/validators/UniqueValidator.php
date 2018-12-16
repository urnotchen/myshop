<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * UniqueValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 12:05
 */
class UniqueValidator extends \yii\validators\UniqueValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::UNIQUE;
        }
    }/*}}}*/
}
