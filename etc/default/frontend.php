<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);

return array(
    'modules' => array(
        'debug' => array(
            'class' => 'yii\debug\Module',
        ),
    ),
    'components' => array(
        'log' => array(
            'targets' => array(
                array(
                    'class' => 'yii\log\DebugTarget',
                )
            ),
        ),
        'multisite' => require 'multisites.php',
    ),
);
