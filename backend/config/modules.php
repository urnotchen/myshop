<?php
return [
    'goods' => [
        'class' => 'backend\modules\goods\Module',
         'as access' => [
             'class' => \yii\filters\AccessControl::className(),
             'rules' => [
                 [
                     'allow' => true,
                     'roles' => ['@'],
                 ],
             ],
//             'denyCallback' => ['\app\components\DenyHandler', 'redirect'],
         ],
    ],
    'settings' => [
        'class' => 'app\modules\settings\Module',
         'as access' => [
             'class' => \yii\filters\AccessControl::className(),
             'rules' => [
                 [
                     'allow' => true,
                     'roles' => ['@'],
                 ],
             ],
             'denyCallback' => ['\app\components\DenyHandler', 'redirect'],
         ],
    ],

        'user' => [
            'class' => 'dektrium\user\Module',
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],

];
