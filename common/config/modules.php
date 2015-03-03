<?php

Yii::setAlias('content',   ROOT . '/modules/content');

return [
    'gii' => [
        'class' => 'yii\gii\Module',
    ],

    'content' => [
        'class' => 'content\Module',
    ],
];