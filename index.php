<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Methods:POST,OPTIONS");
header("Access-Control-Allow-Headers: content-type");
header("Content-Type:application/json;charset=utf8");

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/error.php';

$config = require __DIR__ . '/config/main.php';
Yii::setAlias('@common',__DIR__.DIRECTORY_SEPARATOR.'common');

(new yii\web\Application($config))->run();
