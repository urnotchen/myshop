<?php

namespace common\traits;

use yii\helpers\Json;

trait ErrorsJsonTrait
{

    public function getErrorsJson()
    {
        if (!$this->hasErrors()) {
            return '';
        }
        return Json::encode($this->getErrors());
    }

}
