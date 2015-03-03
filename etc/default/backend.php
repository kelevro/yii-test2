<?php


defined('YII_DEBUG') or define('YII_DEBUG', true);

return array(
    'modules' => array(
    ),
    'components' => array(
        'log' => array(
            'targets' => array(
            ),
        ),
        'multisite' => require 'multisites.php',
    ),
);
