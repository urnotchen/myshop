<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * RequiredValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 10:49
 */
class RequiredValidator extends \yii\validators\RequiredValidator
{

    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            if ($this->requiredValue === null) {
                $this->message = ValidateErrorCode::REQUIRED;
            } else {
                $this->message = ValidateErrorCode::REQUIRED_MUST_BE;
            }
        }
    }/*}}}*/

}
