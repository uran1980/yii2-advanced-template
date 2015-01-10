<?php // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/concept-configurations.md

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
    'bootstrap'           => ['log', 'localeUrls'],
    'controllerNamespace'   => 'backend\modules\backend\controllers',
    'controller'            => '@backend/modules/backend/IndexController',
    'defaultRoute'          => 'backend/index/index',
    'layout'                => '@backend/layouts/main.php',
    'modules' => [
        'backend'   => backend\modules\backend\Module::className(),
        'i18n'      => [
            'class' => Zelenin\yii\modules\I18n\Module::className(),
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
//        'urlManager' => $params['app.urlManager'],
        'urlManager' => $params['app.urlManager.localeUrls'],
        'localeUrls' => $params['app.localeUrls'],
        // here you can set theme used for your backend application
        // - template comes with: 'default', 'slate', 'spacelab' and 'cerulean'
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/modules/backend/views'    => '@webroot/themes/default/views',
                    '@app/modules/translate/views'  => '@webroot/themes/default/views',
                ],
                'baseUrl' => '@web/themes/default',
            ],
        ],
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
