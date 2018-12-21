<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;


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
