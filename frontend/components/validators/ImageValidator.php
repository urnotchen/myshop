<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * ImageValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 11:56
 */
class ImageValidator extends \yii\validators\ImageValidator
{
    public function init()
    {/*{{{*/
        \yii\validators\Validator::init();

        if ($this->notImage === null) {
            $this->notImage = ValidateErrorCode::IMAGE;
        }
        if ($this->underWidth === null) {
            $this->underWidth = ValidateErrorCode::IMAGE_UNDER_WIDTH;
        }
        if ($this->underHeight === null) {
            $this->underHeight = ValidateErrorCode::IMAGE_UNDER_HEIGHT;
        }
        if ($this->overWidth === null) {
            $this->overWidth = ValidateErrorCode::IMAGE_OVER_WIDTH;
        }
        if ($this->overHeight === null) {
            $this->overHeight = ValidateErrorCode::IMAGE_OVER_HEIGHT;
        }
    }/*}}}*/

}
