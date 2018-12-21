<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;


class NumberValidator extends \yii\validators\NumberValidator
{

    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            if ($this->integerOnly) {
                $this->message = ValidateErrorCode::NUMBER_INTEGER;
            } else {
                $this->message = ValidateErrorCode::NUMBER;
            }
        }
        if ($this->min !== null && $this->tooSmall === null) {
            $this->tooSmall = ValidateErrorCode::NUMBER_TOO_SMALL;
        }
        if ($this->max !== null && $this->tooBig === null) {
            $this->tooBig = ValidateErrorCode::NUMBER_TOO_BIG;
        }
    }/*}}}*/

}
