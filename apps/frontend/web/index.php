<?php

mb_internal_encoding('utf-8');
define('APP_TYPE', 'frontend');
define('ROOT', realpath(__DIR__.'/../../..'));

$local          = require ROOT . '/etc/frontend.php';
$localShared    = require ROOT . '/etc/shared.php';
$localParams    = require ROOT . '/etc/params.php';

require ROOT . '/vendor/autoload.php';
require ROOT . '/vendor/yiisoft/yii2/Yii.php';

require(ROOT . '/common/config/aliases.php');

$shared = require ROOT . '/common/config/shared.php';
$web    = require __DIR__ . '/../config/frontend.php';

$config = yii\helpers\ArrayHelper::merge($shared, $localShared, $web, $local, ['params' => $localParams]);

$application = new yii\web\Application($config);
$application->run();
