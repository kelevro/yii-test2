<?php

Yii::setAlias('user',       '@backend/modules/user');
Yii::setAlias('product',   ROOT . '/modules/product');
Yii::setAlias('seo',     ROOT . '/modules/seo');
Yii::setAlias('news',     ROOT . '/modules/news');
Yii::setAlias('slider',     ROOT . '/modules/slider');
Yii::setAlias('mail',     ROOT . '/modules/mail');
Yii::setAlias('statical',     ROOT . '/modules/statical');

return [
    'gii' => [
        'class' => 'yii\gii\Module',
    ],

    'mail' => [
        'class' => 'mail\Module',
    ],
    'statical' => [
        'class'             => '\statical\Module',
        'title'             => 'Static',
    ],
    'product' => [
        'class'             => 'product\Module',
        'title'             => 'Products',
        'params' => [
            'pageSize' => 30,
            'mainImage' => [
                'origin_path'   => '/product/origin',
                'thumbnails'    => [
                    'xsmall' => [
                        'path'      => '/product/xsmall',
                        'size'      => ['width' => 80, 'height' => 80],
                        'bestfit'   => true,
                        'is_tumb'   => true,
                    ],
                    'small' => [
                        'path'      => '/product/small',
                        'size'      => ['width' => 214, 'height' => 170],
                        'bestfit'   => true,
                    ],
                    'medium' => [
                        'path'      => '/product/medium',
                        'size'      => ['width' => 604, 'height' => 453],
                        'bestfit'   => true,
                        'is_main'   => true,
                    ],
                    'big' => [
                        'path'      => '/product/big',
                        'size'      => ['width' => 1200, 'height' => 1080],
                        'bestfit'   => true,
                    ],
                ],
            ],
            'categoryImage' => [
                'origin_path'   => '/product/category/origin',
                'thumbnails'    => [
                    'xsmall' => [
                        'path'      => '/product/category/xsmall',
                        'size'      => ['width' => 80, 'height' => 80],
                        'bestfit'   => true,
                        'is_tumb'   => true,
                    ],
                    'small' => [
                        'path'      => '/product/category/small',
                        'size'      => ['width' => 291, 'height' => 129],
                        'bestfit'   => true,
                    ],
                    'medium' => [
                        'path'      => '/product/category/medium',
                        'size'      => ['width' => 604, 'height' => 453],
                        'bestfit'   => true,
                        'is_main'   => true,
                    ],
                    'big' => [
                        'path'      => '/product/category/big',
                        'size'      => ['width' => 1200, 'height' => 1080],
                        'bestfit'   => true,
                    ],
                ],
            ],
        ],
    ],

    'news' => [
        'class' => 'news\Module',
        'title' => 'News',
        'params' => [
            'pageSize' => 15,
            'mainImage' => [
                'origin_path'   => '/news/main/origin',
                'thumbnails'    => [
                    'xsmall' => [
                        'path' => '/news/main/xsmall',
                        'size' => ['width' => 80, 'height' => 80],
                        'bestfit'   => true,
                    ],
                    'small' => [
                        'path'      => '/news/main/small',
                        'size'      => ['width' => 250, 'height' => 250],
                        'bestfit'   => true,
                    ],
                    'medium' => [
                        'path'      => '/news/main/medium',
                        'size'      => ['width' => 300, 'height' => 300],
                        'bestfit'   => true,
                        'is_main'   => true,
                    ],
                    'big' => [
                        'path'      => '/news/main/big',
                        'size'      => ['width' => 600, 'height' => 600],
                        'bestfit'   => true,
                    ],
                ],
            ],
            'images' => [
                'origin_path'   => '/news/body-images/origin',
                'thumbnails'    => [
                    'new'   => [
                        'path'      => '/news/body-images',
                        'size'      => ['width' => 600, 'height' => 600],
                        'is_main'   => true,
                        'bestfit'   => true,
                    ],
                ],
            ],
        ],
    ],
    'slider' => [
        'class'     => '\slider\Module',
        'images' => [
            'origin_path'   => '/slider/origin',
            'thumbnails'    => [
                'thumb' => [
                    'path' => '/slider/thumb',
                    'size' => ['width' => 150, 'height' => 150],
                    'bestfit'   => true,
                    'is_main' => true,
                ],
                'big' => [
                    'path'      => '/slider/big',
                    'size'      => ['width' => 1000, 'height' => 300],
                    'bestfit'   => true,
                ],
            ],
        ],
    ],

    'seo' => [
        'class' => 'seo\Module',
        'ruleModels' => [
            'product\models\seo\ProductRule',
            'product\models\seo\CategoryRule',
            'news\models\seo\NewRule',
            'news\models\seo\ListNewsRule',
        ],
    ],
];