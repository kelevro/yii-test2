<?php

return [
    'content'  => [
        'icon'  => 'fa-book',
        'title' => 'Content',
        'url'   => '#',
        'subitems' => [
            'books' => [
                'title' => 'Books',
                'url' => ['/content/book/index'],
            ],
            'authors' => [
                'title' => 'Authors',
                'url' => ['/content/author/index'],
            ],
        ],
        'active' => function () {
            return
                (\Yii::$app->controller->module->id == 'content')
                && ((\Yii::$app->controller->id == 'book')
                    || (\Yii::$app->controller->id == 'authors'));
        },
    ],
    'user' => [
        'icon' => 'fa-users',
        'title' => 'Users',
        'url' => '/content/user/index',
        'active' => function () {
            return (\Yii::$app->controller->module->id == 'content')
                && (\Yii::$app->controller->id == 'user');
        },
    ],
];