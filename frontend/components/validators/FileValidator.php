<?php

namespace frontend\components\validators;

use common\components\ValidateErrorCode;

/**
 * FileValidator class file.
 * @Author haoliang
 * @Date 24.02.2016 10:33
 */
class FileValidator extends \yii\validators\FileValidator
{

    public function init()
    {/*{{{*/

        \yii\validators\Validator::init();

        if ($this->message === null) {
            $this->message = ValidateErrorCode::FILE;
        }
        if ($this->uploadRequired === null) {
            $this->uploadRequired = ValidateErrorCode::FILE_REQUIRED;
        }
        if ($this->tooMany === null) {
            $this->tooMany = ValidateErrorCode::FILE_TOO_MANY;
        }
        if ($this->wrongExtension === null) {
            $this->wrongExtension = ValidateErrorCode::FILE_WRONG_EXTENSION;
        }
        if ($this->tooBig === null) {
            $this->tooBig = ValidateErrorCode::FILE_TOO_BIG;
        }
        if ($this->tooSmall === null) {
            $this->tooSmall = ValidateErrorCode::FILE_TOO_SMALL;
        }
        if (!is_array($this->extensions)) {
            $this->extensions = preg_split('/[\s,]+/', strtolower($this->extensions), -1, PREG_SPLIT_NO_EMPTY);
        } else {
            $this->extensions = array_map('strtolower', $this->extensions);
        }
        if ($this->wrongMimeType === null) {
            $this->wrongMimeType = ValidateErrorCode::FILE_WRONG_MIME_TYPE;
        }
        if (!is_array($this->mimeTypes)) {
            $this->mimeTypes = preg_split('/[\s,]+/', strtolower($this->mimeTypes), -1, PREG_SPLIT_NO_EMPTY);
        } else {
            $this->mimeTypes = array_map('strtolower', $this->mimeTypes);
        }
    }/*}}}*/

}
