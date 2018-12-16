<?php

namespace frontend\components\rest;

use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use yii\base\UserException;

class ErrorAction extends \yii\web\ErrorAction
{

    public function run()
    {

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return [
                'statusCode' => '404',
                'name'       => '"Page not found."',
                'code'       => \common\components\ResponseCode::NOT_FOUND,
            ];
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }

        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?: 'Error';
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: '"An internal server error occurred."';
        }

        return compact('name', 'code', 'message');
    }

}
