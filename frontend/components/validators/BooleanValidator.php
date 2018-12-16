<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * BooleanValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 11:16
 */
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
