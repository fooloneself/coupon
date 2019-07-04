<?php
$env=constant('YII_ENV');

$params = require __DIR__ .DIRECTORY_SEPARATOR.$env.DIRECTORY_SEPARATOR. 'params.php';
$db = require __DIR__ .DIRECTORY_SEPARATOR.$env.DIRECTORY_SEPARATOR . 'db.php';
$basePath=dirname(__DIR__);
$config = [
    'id' => 'basic',
    'basePath' => $basePath,
    'bootstrap' => ['log'],
    'aliases' => [
    ],
    'components' => [
        'request' => [
            'class'=>'common\components\Request',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ZxQ4v3u3O1cnPEJBLK8EwtZ9FtDB8AvE',
        ],
        'response'=>[
            'class'=>'common\components\Response'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'class'=>'common\components\ErrorHandler',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'user' =>  'app\modules\user\Module',
        'merchant' =>'app\modules\merchant\Module',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
