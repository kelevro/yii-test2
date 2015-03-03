<?php
$rootDir = __DIR__ . '/../..';



return [
    'id'                  => 'app-console',
    'controllerNamespace' => 'console\controllers',

    'components'          => [
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class'           => '\yii\rbac\DbManager',
            'itemTable'       => 'auth_item',
            'itemChildTable'  => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
        ],
    ],
    'params' => array_merge(
        require(ROOT . '/common/config/params.php'),
        require(__DIR__ . '/params.php')
    ),
];
