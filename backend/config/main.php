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
    'id'                    => 'app-backend',
    'basePath'              => dirname(__DIR__),
    'bootstrap'             => ['log'],
    'controllerNamespace'   => 'backend\modules\backend\controllers',
    'controller'            => '@backend/modules/backend/IndexController',
    'defaultRoute'          => 'backend/index/index',
    'layout'                => '@backend/layouts/main.php',
    'modules' => [
        'backend' => backend\modules\backend\Module::className(),
    ],
    'components' => [
        'urlManager' => $params['app.urlManager'],
        // here you can set theme used for your backend application
        // - template comes with: 'default', 'slate', 'spacelab' and 'cerulean'
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/modules/site/views'    => '@webroot/themes/default/views',
                    '@app/modules/profile/views' => '@webroot/themes/default/views',
                    '@app/modules/test/views'    => '@webroot/themes/default/views',
                ],
                'baseUrl' => '@web/themes/default',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/runtime-logging.md#log-targets
            'targets' => [
                'file' => [
                    'class'     => yii\log\FileTarget::className(),
                    'levels'    => ['error', 'warning'],
                ],
                'dbLogger' => [
                    'class'  => common\components\log\AppLoggerDbTarget::className(),
                    'levels' => ['info', 'error', 'warning'],
                    'categories' => [
                        AppLogger::CATEGORY_APPLICATION,
                        AppLogger::CATEGORY_TEST,
                        AppLogger::CATEGORY_BACKEND,
                    ],
                    'logTable' => 'log',
                ],
//                // email target example
//                'email' => [
//                    'class' => 'yii\log\EmailTarget',
//                    'levels' => ['error', 'warning'],
//                    'message' => [
//                        'to' => 'admin@example.com',
//                    ],
//                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'backend/index/error',
        ],
    ],
    'params' => $params,
];

return $config;
