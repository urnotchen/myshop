<?php

namespace frontend\components\validators;

use yii\base\InvalidConfigException;
use common\components\ValidateErrorCode;

class DateValidator extends \yii\validators\DateValidator
{
    public function init()
    {
        \yii\validators\Validator::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::DATE;
        }
        if ($this->format === null) {
            $this->format = Yii::$app->formatter->dateFormat;
        }
        if ($this->locale === null) {
            $this->locale = Yii::$app->language;
        }
        if ($this->timeZone === null) {
            $this->timeZone = Yii::$app->timeZone;
        }
        if ($this->min !== null && $this->tooSmall === null) {
            $this->tooSmall = ValidateErrorCode::DATE_TOO_SMALL;
        }
        if ($this->max !== null && $this->tooBig === null) {
            $this->tooBig = ValidateErrorCode::DATE_TOO_BIG;
        }
        if ($this->maxString === null) {
            $this->maxString = (string) $this->max;
        }
        if ($this->minString === null) {
            $this->minString = (string) $this->min;
        }
        if ($this->max !== null && is_string($this->max)) {
            $timestamp = $this->parseDateValue($this->max);
            if ($timestamp === false) {
                throw new InvalidConfigException("Invalid max date value: {$this->max}");
            }
            $this->max = $timestamp;
        }
        if ($this->min !== null && is_string($this->min)) {
            $timestamp = $this->parseDateValue($this->min);
            if ($timestamp === false) {
                throw new InvalidConfigException("Invalid min date value: {$this->min}");
            }
            $this->min = $timestamp;
        }
    }
}
