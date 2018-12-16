<?php

namespace frontend\components\validators;

use yii\base\InvalidConfigException;
use common\components\ValidateErrorCode;

/**
 * CompareValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 11:20
 */
class CompareValidator extends \yii\validators\CompareValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->message === null) {
            switch ($this->operator) {
                case '==':
                    $this->message = ValidateErrorCode::COMPARE_EQUAL;
                    break;
                case '===':
                    $this->message = ValidateErrorCode::COMPARE_EQUAL;
                    break;
                case '!=':
                    $this->message = ValidateErrorCode::COMPARE_NOT_EQUAL;
                    break;
                case '!==':
                    $this->message = ValidateErrorCode::COMPARE_NOT_EQUAL;
                    break;
                case '>':
                    $this->message = ValidateErrorCode::COMPARE_GEATER;
                    break;
                case '>=':
                    $this->message = ValidateErrorCode::COMPARE_GEATER_OR_EQUAL;
                    break;
                case '<':
                    $this->message = ValidateErrorCode::COMPARE_LESS;
                    break;
                case '<=':
                    $this->message = ValidateErrorCode::COMPARE_LESS_OR_EQUAL;
                    break;
                default:
                    throw new InvalidConfigException("Unknown operator: {$this->operator}");
            }
        }
    }/*}}}*/

}
