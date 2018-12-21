<?php

namespace frontend\components\validators;

use yii\base\InvalidConfigException;
use common\components\ValidateErrorCode;

class RangeValidator extends \yii\validators\RangeValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if (!is_array($this->range)
            && !($this->range instanceof \Closure)
            && !($this->range instanceof \Traversable)
        ) {
            throw new InvalidConfigException('The "range" property must be set.');
        }
        if ($this->message === null) {
            $this->message = ValidateErrorCode::RANGE;
        }
    }/*}}}*/
}
