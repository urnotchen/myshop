<?php


Yii::$container->set('kartik\daterange\DateRangePicker', [
    'convertFormat'=>true,
    'pluginOptions'=>[
        'timePicker' => true,
        'locale' => [
            'format'     => 'Y-m-d H:i',
            'separator'  => ' ~ ',
        ],
        'timePickerIncrement' => 5,
    ],
]);