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
        'class' => 'backend\modules\settings\Module',
         'as access' => [
             'class' => \yii\filters\AccessControl::className(),
             'rules' => [
                 [
                     'allow' => true,
                     'roles' => ['?'],
                 ],
             ],
//             'denyCallback' => ['\app\components\DenyHandler', 'redirect'],
         ],
    ],

    'order' => [
        'class' => 'backend\modules\order\Module',
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

    'admin' => [
        'class' => 'mdm\admin\Module',
        'layout' => 'left-menu',//yii2-admin的导航菜单
    ]

];
