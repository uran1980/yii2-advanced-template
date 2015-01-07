<?php

use yii\helpers\ArrayHelper;
use common\components\log\AppLogger;

$params = ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        // here you can set theme used for your backend application
        // - template comes with: 'default', 'slate', 'spacelab' and 'cerulean'
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@webroot/themes/default/views'],
                'baseUrl' => '@web/themes/default',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'file' => [
                    'class'     => yii\log\FileTarget::className(),
                    'levels'    => ['error', 'warning'],
                ],
                'dbLogger' => [
                    'class'  => common\components\log\AppLoggerDbTarget::className(),
                    'levels' => ['info', 'error', 'warning'],
                    'categories' => [
                        AppLogger::CATEGORY_BACKEND,
                    ],
                    'logTable' => 'log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

return $config;
