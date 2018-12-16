<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * EachValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 11:49
 */
class EachValidator extends \yii\validators\EachValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::EACH;
        }
    }/*}}}*/

}
