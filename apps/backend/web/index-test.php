<?php

mb_internal_encoding('utf-8');
define('APP_TYPE', 'backend');
define('ROOT', realpath(__DIR__.'/../..'));
require ROOT. '/c3.php';

$local = require ROOT . '/etc/backend.php';

require ROOT . '/vendor/autoload.php';
require ROOT . '/vendor/yiisoft/yii2/Yii.php';

$shared = require ROOT . '/common/config/shared.php';
$test = require ROOT . '/tests/config.php';
$web = require __DIR__ . '/../config/backend.php';

$config = yii\helpers\ArrayHelper::merge($shared, $web, $local, $test);
require ROOT.'/tests/require.php';
$application = new yii\web\Application($config);
define('MY_APP_STARTED', true);
$application->run();
