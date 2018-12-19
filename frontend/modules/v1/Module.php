<?php

namespace frontend\modules\v1;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\v1\controllers';

    public function init()
    {
        parent::init();

        $this->restfullable();
    }

    protected function restfullable()
    {
        \Yii::configure(\Yii::$app->request, [
            //启用CSRF(跨站点请求伪造)验证
            'enableCsrfValidation'   => true,
            //禁用cookie记住Csrf token
            'enableCsrfCookie'       => false,
            //是否验证cookie确保他们不相互干扰
            'enableCookieValidation' => false,
            //使api接收jso格式的输入数据
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ]);

        \Yii::configure(\Yii::$app, ['components' => [
            'deviceCache' => [
                'class' => 'frontend\modules\v1\components\DeviceCache',
            ],
            'passwordTokenCache' => [
                'class' => 'frontend\modules\v1\components\TokenCache',
                'keyString' => "sb_%s_chgPwdToken",
            ],
            'captchaCache' => [
                'class' => 'frontend\modules\v1\components\CaptchaCache',
            ],
        ]]);

        //返回响应前执行，格式化响应
        \Yii::configure(\Yii::$app->response, [
            'on beforeSend' => [$this, 'formatResponse'],
        ]);

        \Yii::configure(\Yii::$app->errorHandler, [
            'errorAction' => 'site/api-error',
        ]);

        $this->embedBuiltInValidators();
    }

    /**
     * 返回响应前执行，格式化响应
     */
    protected function formatResponse($event)
    {

        $response = $event->sender;

        /* html, xml ... */

        if ($response->format != \yii\web\Response::FORMAT_JSON) {

            return true;
        }

        /* json */

        $responseData = [
            'status'  => $response->statusCode,
            'success' => $response->isSuccessful,
        ];
        $statusCode = 200;

        if ($response->isSuccessful) {
            $responseData['data'] = $response->data;
            $statusCode = 200;
        } elseif ($response->isClientError) {
            $responseData['code']    = $response->data['code'];
            $responseData['name'] = $response->data['name'];
            try {
                $responseData['errors'] = \yii\helpers\Json::decode($response->data['message']);
            } catch (\yii\base\InvalidParamException $e) {
                $responseData['errors'] = $response->data['message'];
            }
            $statusCode = 200;
        } elseif ($response->isServerError) {
            /* server-error must log */
            $statusCode = $response->statusCode;
            $responseData['name'] = 'server error.';
            $responseData['debug'] = $response->data;
        } else {
            $statusCode = $response->statusCode;
        }

        $response->data       = $responseData;
        $response->statusCode = $statusCode;

    }

    protected function embedBuiltInValidators()
    {
        $namespace = 'frontend\components\validators';

        \yii\validators\Validator::$builtInValidators = [

            'boolean'  => "{$namespace}\\BooleanValidator",
            'compare'  => "{$namespace}\\CompareValidator",
            'date'     => "{$namespace}\\DateValidator",
            'default'  => "{$namespace}\\DefaultValueValidator",
            'double'   => "{$namespace}\\NumberValidator",
            'each'     => "{$namespace}\\EachValidator",
            'email'    => "{$namespace}\\EmailValidator",
            'exist'    => "{$namespace}\\ExistValidator",
            'file'     => "{$namespace}\\FileValidator",
            'filter'   => "{$namespace}\\FilterValidator",
            'image'    => "{$namespace}\\ImageValidator",
            'in'       => "{$namespace}\\RangeValidator",
            'match'    => "{$namespace}\\RegularExpressionValidator",
            'number'   => "{$namespace}\\NumberValidator",
            'required' => "{$namespace}\\RequiredValidator",
            'safe'     => "{$namespace}\\SafeValidator",
            'string'   => "{$namespace}\\StringValidator",
            'unique'   => "{$namespace}\\UniqueValidator",
            'url'      => "{$namespace}\\UrlValidator",
            'ip'       => "{$namespace}\\IpValidator",
            'spe_required' => "{$namespace}\\SpeRequiredValidator",

            'integer' => [
                'class' => "{$namespace}\\NumberValidator",
                'integerOnly' => true,
            ],

            'trim' => [
                'class' => "{$namespace}\\FilterValidator",
                'filter' => 'trim',
                'skipOnArray' => true,
            ],

            'array' => 'frontend\components\validators\ArrayValidator',
        ];
    }

}
