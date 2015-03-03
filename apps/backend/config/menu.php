<?php

return [
    'slider' => [
        'icon' => 'fa-desktop',
        'title' => 'Slider',
        'url' => '/slider/default/index',
        'active' => function () {
            return \Yii::$app->controller->module->id == 'slider';
        },
    ],
    'statical' => [
        'icon'      => 'fa-book',
        'title'     => 'Static',
        'url'       => '#',
        'subitems' => [
            'page-list' => [
                'title' => 'Page list',
                'url' => ['/statical/default/index'],
            ],
            'text-list' => [
                'title' => 'Text list',
                'url' => ['/statical/text/index'],
            ],
        ],
        'active'    => function () {
                return \Yii::$app->controller->module->id == 'statical';
            },
    ],
    'mail'  => [
        'icon'  => 'fa-envelope',
        'title' => 'Email',
        'url'   => '/mail/subscriber/index',
        'active' => function () {
            return
                (\Yii::$app->controller->module->id == 'mail')
                && (\Yii::$app->controller->module->id == 'subscriber');
        },
    ],
    'product' => [
        'icon' => 'fa-inbox',
        'title' => 'Product',
        'url' => '#',
        'subitems' => [
            'product-list' => [
                'title' => 'List',
                'url' => ['/product/product/list'],
            ],
            'product-deleted' => [
                'title' => 'List Deleted',
                'url' => ['/product/product/list-deleted'],
            ],
            'product-category' => [
                'title' => 'Category',
                'url' => ['/product/category/list'],
            ],
            'product-attribute' => [
                'title' => 'Attributes',
                'url' => ['/product/attribute/list'],
            ],
            'product-import' => [
                'title' => 'Import',
                'url' => ['/product/import/index'],
            ],
        ],
        'active' => function () {
            return \Yii::$app->controller->module->id == 'product'
                    && (\Yii::$app->controller->id == 'category'
                        || \Yii::$app->controller->id == 'product'
                        || \Yii::$app->controller->id == 'attribute');
        },
    ],
    'order' => [
        'icon' => 'fa-shopping-cart',
        'title' => 'Orders',
        'url' => '/product/order/list',
        'active' => function () {
                return \Yii::$app->controller->id == 'order';
            },
    ],
    'news' => [
        'icon' => 'fa-calendar',
        'title' => 'News',
        'url' => '#',
        'subitems' => [
            'news-list' => [
                'title' => 'List',
                'url' => ['/news/default/index'],
            ],
            'new-add' => [
                'title' => 'Add new',
                'url' => ['/news/default/update'],
            ],
        ],
        'active' => function () {
                return \Yii::$app->controller->module->id == 'news';
            },
    ],
//    'backend-users' => [
//        'icon' => 'fa-user-md',
//        'title' => 'Admin',
//        'url' => '#',
//        'subitems' => [
//            'users-list' => [
//                'title' => 'List',
//                'url' => ['/user/manage/index'],
//            ],
//            'users-rbac' => [
//                'title' => 'RBAC',
//                'url' => ['/user/item/index'],
//            ],
//        ],
//        'active' => function () {
//            return \Yii::$app->controller->module->id == 'user';
//        },
//    ],
    'documentation'  => [
        'icon'  => 'fa-book',
        'title' => 'Documents',
        'url'   => '#',
        'subitems' => [
            'list' => [
                'title' => 'List',
                'url' => ['/product/documentation/index'],
            ],
            'category' => [
                'title' => 'Category',
                'url' => ['/product/documentation-category/index'],
            ],
        ],
        'active' => function () {
                return
                    (\Yii::$app->controller->module->id == 'product')
                    && ((\Yii::$app->controller->id == 'documentation')
                        || (\Yii::$app->controller->id == 'documentation-category'));
            },
    ],
];