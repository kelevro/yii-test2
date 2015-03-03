<?php
mb_internal_encoding('utf-8');
define('APP_TYPE', 'backend');
define('ROOT', realpath(__DIR__.'/../../..'));

$local = require ROOT . '/etc/backend.php';
$params = require ROOT . '/etc/params.php';

require ROOT . '/vendor/autoload.php';
require ROOT . '/vendor/yiisoft/yii2/Yii.php';

$shared = require ROOT . '/common/config/shared.php';
$web = require __DIR__ . '/../config/backend.php';

$config = yii\helpers\ArrayHelper::merge($shared, $web, $local, ['params' => $params]);

$application = new yii\web\Application($config);
$application->run();
