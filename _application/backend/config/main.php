<?php

// Docs links:
// 1) https://github.com/yiisoft/yii2/blob/master/docs/guide/concept-configurations.md
// 2) https://github.com/yiisoft/yii2/blob/master/docs/guide/structure-controllers.md#default-controller-

use yii\helpers\ArrayHelper;
use common\components\log\AppLogger;
use common\rbac\AccessControl;

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
    'defaultRoute'          => 'backend/index/index',                           // @see link 2)
    'layout'                => '@backend/layouts/main.php',
    'modules' => [
        'backend'   => backend\modules\backend\Module::className(),
        'i18n'      => [
            'class' => uran1980\yii\modules\i18n\Module::className(),
            'controllerMap' => [
                'default' => uran1980\yii\modules\i18n\controllers\DefaultController::className(),
            ],
            'as access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers'   => ['i18n/default'],
                        'actions'       => ['index', 'save', 'update', 'rescan', 'clear-cache', 'delete', 'restore'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_TRANSLATOR],
                    ],
                ],
            ],
        ],
    ],
    'components' => [
//        'urlManager'    => $params['app.urlManager'],
        'urlManager' => $params['app.urlManager.localeUrls'],
        'urlManagerFrontend' => $params['app.urlManagerFrontend'],
        'view' => $params['app.view'],
        'user' => [
            'class'             => yii\web\User::className(),
            'identityClass'     => common\models\identity\UserIdentity::className(),
            'enableAutoLogin'   => true,
            'loginUrl'          => '/backend/login',
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
                    'logVars' => ['_GET', '_POST'],                             // @see yii2\log\Target.php
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
            'class'         => yii\web\ErrorHandler::className(),
//            'class'         => common\components\web\ErrorHandler::className(), // TODO
            'errorAction'   => 'backend/index/error',
        ],
    ],
    'params' => $params,
];

return $config;
