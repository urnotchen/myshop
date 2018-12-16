<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * ArrayValidator class file.
 * @Author haoliang
 * @Date 10.05.2016 20:33
 */
class ArrayValidator extends \yii\validators\Validator
{

    public $max;
    public $min;

    public $message;
    public $tooLong;
    public $tooShort;

    public function init()
    {/*{{{*/
        parent::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::MUST_ARRAY;
        }
        if ($this->min !== null && $this->tooShort === null) {
            $this->tooShort = ValidateErrorCode::ARRAY_TOO_SHORT;
        }
        if ($this->max !== null && $this->tooLong === null) {
            $this->tooLong = ValidateErrorCode::ARRAY_TOO_LONG;
        }
    }/*}}}*/

    public function validateAttribute($model, $attribute)
    {/*{{{*/
        $value = $model->{$attribute};

        if (! is_array($value)) {
            $this->addError($model, $attribute, $this->message);
            return;
        }

        $length = count($value);

        if ($this->min !== null && $length < $this->min) {
            $this->addError($model, $attribute, $this->tooShort, ['min' => $this->min]);
        }
        if ($this->max !== null && $length > $this->max) {
            $this->addError($model, $attribute, $this->tooLong, ['max' => $this->max]);
        }

    }/*}}}*/

}
