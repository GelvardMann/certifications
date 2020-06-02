<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'name' => 'Certifications',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache' //Включаем кеширование
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'common\modules\user\UserModule',
        ],
        'certification' => [
            'class' => 'common\modules\certification\Module',
        ],
    ],
];
