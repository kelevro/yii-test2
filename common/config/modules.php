<?php

Yii::setAlias('content',   ROOT . '/modules/content');
Yii::setAlias('search',   ROOT . '/modules/search');

return [
    'gii' => [
        'class' => 'yii\gii\Module',
        'generators' => [
            'sphinxModel' => [
                'class' => 'yii\sphinx\gii\model\Generator',
            ],
        ],
    ],

    'content' => [
        'class' => 'content\Module',
    ],

    'search' => [
        'class' => 'search\Module',
    ],
];