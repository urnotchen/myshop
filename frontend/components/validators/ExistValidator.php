<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

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
