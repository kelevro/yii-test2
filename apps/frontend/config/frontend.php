<?php

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'request' => [
                    'cookieValidationKey' => 'root1007',
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
        'view' => [
            'theme' => [
                'class' => '\frontend\themes\base\Theme',
                'basePath' => '@frontend/themes/base',
                'baseUrl'  => '@web',
                'pathMap'  => [
                    '@frontend/views' => '@frontend/themes/base/views',
                ],
            ],
        ],
        'seo' => [
            'class' => '\seo\components\Manager',
        ],
    ],
    'params' => array_merge(
        require ROOT . '/common/config/params.php',
        require __DIR__ . '/params.php'
    ),
];
