<?php

return [
    'id'                  => 'Yii test backend',
    'bootstrap'             => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'viewPath'            => '@app/apps/backend/views',
    'language'            => 'ru',

    'modules'             => [
        'gii'    => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'app-crud' => [
                    'class' => 'backend\gii\crud\Generator',
                ],
            ],
        ],
        'user'    => [
            'class' => 'user\Module',
        ],
    ],

    'components'          => [
        'user' => [
            'class'         => 'user\components\User',
            'identityClass' => 'user\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'root1007',
        ],
        'authManager' => [
            'class' => '\yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'itemChildTable' => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
        ],
        'log'  => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'backend' => [
                    'class'          => 'yii\i18n\MessageSource',
                    'sourceLanguage' => 'ru_RU',
                ],
                'yii' => [
                    'class'          => 'yii\i18n\MessageSource',
                    'sourceLanguage' => 'ru_RU',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => true,
        ],
    ],
    'params'              => array_merge(
        require(ROOT . '/common/config/params.php'),
        require(__DIR__ . '/params.php')
    ),
];
