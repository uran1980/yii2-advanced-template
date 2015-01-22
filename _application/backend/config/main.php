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
    'bootstrap'             => ['log', 'localeUrls'],
    'controllerNamespace'   => 'backend\modules\backend\controllers',
    'controller'            => '@backend/modules/backend/IndexController',
    'defaultRoute'          => 'backend/index/index',                           // @see link 2)
    'layout'                => '@backend/layouts/main.php',
    'modules' => [
        'backend'   => backend\modules\backend\Module::className(),
        'i18n'      => [
            'class' => Zelenin\yii\modules\I18n\Module::className(),
            'controllerMap' => [
                'default' => common\modules\i18n\controllers\DefaultController::className(),
            ],
            'as access' => [
                'class' => yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'controllers'   => ['i18n/default'],
                        'actions'       => ['index', 'update'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_ADMIN],
                    ],
                ],
            ],
        ],
    ],
    'components' => [
//        'urlManager'    => $params['app.urlManager'],
        'urlManager' => $params['app.urlManager.localeUrls'],
        'urlManagerFrontend' => $params['app.urlManagerFrontend'],
        'localeUrls' => $params['app.localeUrls'],
        'view' => $params['app.view'],
        'user' => [
            'class'             => yii\web\User::className(),
            'identityClass'     => common\models\UserIdentity::className(),
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
            'errorAction' => 'backend/index/error',
        ],
    ],
    'params' => $params,
];

return $config;
