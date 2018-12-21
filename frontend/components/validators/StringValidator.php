<?php

namespace frontend\components\validators;

use Yii;
use common\components\ValidateErrorCode;

class StringValidator extends \yii\validators\StringValidator
{

    public function init()
    {/*{{{*/

        \yii\validators\Validator::init();

        if (is_array($this->length)) {
            if (isset($this->length[0])) {
                $this->min = $this->length[0];
            }
            if (isset($this->length[1])) {
                $this->max = $this->length[1];
            }
            $this->length = null;
        }

        if ($this->encoding === null) {
            $this->encoding = Yii::$app->charset;
        }

        if ($this->message === null) {
            $this->message = ValidateErrorCode::STRING;
        }
        if ($this->min !== null && $this->tooShort === null) {
            $this->tooShort = ValidateErrorCode::STRING_TOO_SHORT;
        }
        if ($this->max !== null && $this->tooLong === null) {
            $this->tooLong = ValidateErrorCode::STRING_TOO_LONG;
        }
        if ($this->length !== null && $this->notEqual === null) {
            $this->notEqual = ValidateErrorCode::STRING_NOT_EQUAL;
        }

    }/*}}}*/

}
