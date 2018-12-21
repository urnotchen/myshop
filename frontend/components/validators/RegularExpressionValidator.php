<?php

namespace frontend\components\validators;

use yii\base\InvalidConfigException;
use common\components\ValidateErrorCode;


class RegularExpressionValidator extends \yii\validators\RegularExpressionValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->pattern === null) {
            throw new InvalidConfigException('The "pattern" property must be set.');
        }
        if ($this->message === null) {
            $this->message = ValidateErrorCode::REGEX;
        }
    }/*}}}*/
}
