<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

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
