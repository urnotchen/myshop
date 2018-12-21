<?php

namespace frontend\components\validators;

use yii\base\InvalidConfigException;
use common\components\ValidateErrorCode;


class UrlValidator extends \yii\validators\UrlValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->enableIDN && !function_exists('idn_to_ascii')) {
            throw new InvalidConfigException('In order to use IDN validation intl extension must be installed and enabled.');
        }
        if ($this->message === null) {
            $this->message = ValidateErrorCode::URL;
        }
    }/*}}}*/
}
