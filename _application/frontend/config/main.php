<?php

// Docs links:
// 1) https://github.com/yiisoft/yii2/blob/master/docs/guide/concept-configurations.md
// 2) https://github.com/yiisoft/yii2/blob/master/docs/guide/structure-controllers.md#default-controller-

use yii\helpers\ArrayHelper;
use common\components\log\AppLogger;

$params = ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\modules\site\controllers',
    'controller'          => '@frontend/modules/site/IndexController',
    'defaultRoute'        => 'site/index/index',                                // @see link 2)
    'layout'              => '@frontend/layouts/main.php',
    'modules' => [
        'site'      => frontend\modules\site\Module::className(),
        'profile'   => frontend\modules\profile\Module::className(),
    ],
    'components' => [
        'urlManager'        => $params['app.urlManager.localeUrls'],
        'urlManagerBackend' => $params['app.urlManagerBackend'],
        'view'              => $params['app.view'],
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
                    'logVars' => ['_GET', '_POST'],                             // @see yii2\log\Target.php
                    'categories' => [
                        AppLogger::CATEGORY_APPLICATION,
                        AppLogger::CATEGORY_TEST,
                        AppLogger::CATEGORY_FRONTEND,
                        AppLogger::CATEGORY_PROFILE,
                        AppLogger::CATEGORY_SITE,
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
            'class'         => yii\web\ErrorHandler::className(),
//            'class'         => common\components\web\ErrorHandler::className(), // TODO
            'errorAction'   => 'site/index/error',
        ],
    ],
    'params' => $params,
];

if ( YII_ENV_DEV ) {
    $config['modules']['test'] = frontend\modules\test\Module::className();
}

return $config;