<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => require(__DIR__ . '/modules.php'),
    'language' => 'zh-CN',
    'name' => '分销系统',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
                ''       => 'site/index',
                'logout' => 'site/logout',

                'logx'      => 'logx/default/index',
                'logx/view' => 'logx/default/view',

                '<controller:[a-z-]+>' => '<controller>',
                '<controller:[a-z-]+>/<action:[a-z-]+>' => '<controller>/<action>',
                '<controller:[a-z-]+>/<action:[a-z-]+>/<id:[0-9]+>' => '<controller>/<action>',
                '<module:[a-z-]+>/<controller:[a-z-]+>/<action:[a-z-]+>' => '<module>/<controller>/<action>',

            ],
        ],
        'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
                'site/*',//允许访问的节点，可自行添加
                'admin/*',//允许所有人访问admin节点及其子节点
            ]
        ],
        'sidebarItems' => [
            'class' => 'common\widgets\SidebarItems',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte'
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'forceCopy' => false,
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'css' => [
                        '/css/AdminLTE.min.css',
                    ],
                ],
            ],
        ],
    ],

    'params' => $params,
];
