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
    'report'  => [
        'icon'  => 'fa-inbox',
        'title' => 'Reports',
        'url'   => '#',
        'subitems' => [
            'task1' => [
                'title' => 'Task 1',
                'url' => ['/content/report/task-1'],
            ],
            'task2' => [
                'title' => 'Task 2',
                'url' => ['/content/report/task-2'],
            ],
            'task3' => [
                'title' => 'Task 3',
                'url' => ['/content/report/task-3'],
            ],
        ],
        'active' => function () {
            return
                (\Yii::$app->controller->module->id == 'content')
                && (\Yii::$app->controller->id == 'report');
        },
    ],
    'search'  => [
        'icon'  => 'fa-search',
        'title' => 'Search',
        'url'   => '/content/search',
        'active' => function () {
            return
                (\Yii::$app->controller->module->id == 'content')
                && (\Yii::$app->controller->id == 'search');
        },
    ],
];