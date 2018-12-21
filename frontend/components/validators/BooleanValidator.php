<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

class BooleanValidator extends \yii\validators\BooleanValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::BOOLEAN;
        }
    }/*}}}*/

}
