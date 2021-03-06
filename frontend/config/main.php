<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
//        'request' => [
//            'csrfParam' => '_csrf-frontend',
//        ],
//        'user' => [
//            'identityClass' => 'common\models\FUser',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
        'user' => [
            'class'         => 'frontend\components\rest\User',
            'identityClass' => 'frontend\models\FUser',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'request' => [
            'class' => 'frontend\components\rest\Request',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [

                '' => 'site/index',

                'v1' => 'v1',
                'v1/<controller:[a-z-]+>/<action:[a-z-]+>' => 'v1/<controller>/<action>',

                '<controller:[a-z-]+>/<action:[a-z-]+>' => '<controller>/<action>',

            ],
        ],
        'wxAuthorization' => [
            'class' => 'frontend\components\WxAuthorization',
            'scope' => 'snsapi_userinfo',
            'app_id' => 'wxb7ba89d49cdacf6b',
            'app_secret' => '7f06ea2e6c9465b0d67a4d2855a756b1',
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module',
        ],
    ],
    'params' => $params,
];
