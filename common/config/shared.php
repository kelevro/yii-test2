<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/../components/functions.php';
require __DIR__ . '/../helpers/Y.php';

$dbs = require ROOT.'/etc/databases.php';

require 'aliases.php';

return [
    'id'         => 'rk-electronics-app',
    'name'       => 'RK Electronics',
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
            'rules'           => [
                '/contacts'             => 'site/contacts',
                '/'                     => 'site/index',
                '/sitemap.xml'          => 'sitemap/index',
                '/brands'               => 'static/brands',
                '/catalog'              => 'product/default/catalog',
                '/search'               => 'product/default/general-search-result',
                '/news'                 => 'news/default/index',
                '/documentation'        => 'product/documentation/list',

                ['class' => 'news\urls\NewRule'],
                ['class' => 'product\urls\CategoryRule'],
                ['class' => 'product\urls\ProductRule'],
                ['class' => 'statical\urls\PageRule'],

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ]
        ],
        'mail' => [
            'class'     => 'common\base\Mailer',
            'viewPath'  => '@frontend/views/mail',
            'htmlLayout' => false,
            'transport' => [
                'class'         => 'Swift_SmtpTransport',
                'host'          => 'smtp.yandex.ru',
                'username'      => 'info@seges-electronics.ru',
                'password'      => '17segSAm03',
                'port'          => '25',
            ],
        ],

    ],
    'params'     => require_once 'params.php',
];
