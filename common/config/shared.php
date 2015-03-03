<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/../helpers/Y.php';

$dbs = require ROOT.'/etc/databases.php';

require 'aliases.php';

return [
    'id'         => 'yii-test',
    'name'       => 'Yii test',
    'basePath'   => ROOT,
    'vendorPath' => ROOT . '/vendor',

    'modules' => require_once 'modules.php',

    'extensions' => require ROOT . '/vendor/yiisoft/extensions.php',

    'components' => [
        'db'       => $dbs['db'],

        'cache'      => require ROOT . '/etc/cache.php',

        'elog'       => [
            'class' => '\sergebezborodov\elogger\ELogger',
            'handlers' => [
                [
                    'class' => '\sergebezborodov\elogger\handlers\File',
                    'path' => '@app/runtime/logs',
                ],
                [
                    'class' => '\sergebezborodov\elogger\handlers\Console',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
    ],
    'params'     => require_once 'params.php',
];
