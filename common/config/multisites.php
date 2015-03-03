<?php


return [
    'class'      => '\common\components\ms\MultiSiteManager',
    'units'      => [
        'project' => [
            'hw_ru' => [
                'class'      => '\common\components\ms\Project',
                'id'         => 1,
                'attributes' => [
                    'country' => 'ukraine',
                ],
            ],
        ],
    ],
    'multisites' => [
        'book4u' => [
            'class' => '\common\components\ms\MultiSite',
            'id' => 1,
            'rule' => [
                'class'             => 'multisite2\UrlRule',
                'url'               => 'books4u.in.ua',
                'withSubdomains'    => true
            ],
            'attributes' => [
                'title'   => 'books4u.in.ua',
                'domain'  => 'books4u.in.ua',
                'storage' => 'storage.books4u.in.ua',
                'alias'   => 'books',
            ],
            'theme' => [
                'class' => '\frontend\themes\book\Theme',
                'basePath' => '@frontend/themes/book',
                'baseUrl'  => '@web',
                'pathMap'  => [
                    '@frontend/views' => '@frontend/themes/book/views',
                ],
            ],
        ],
    ],
];