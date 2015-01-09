<?php // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/concept-configurations.md

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
    'bootstrap'           => ['log', 'localeUrls'],
    'controllerNamespace'   => 'backend\modules\backend\controllers',
    'controller'            => '@backend/modules/backend/IndexController',
    'defaultRoute'          => 'backend/index/index',
    'layout'                => '@backend/layouts/main.php',
    'modules' => [
        'backend'   => backend\modules\backend\Module::className(),
//        'translate' => backend\modules\translate\Module::className(),
        'i18n'      => Zelenin\yii\modules\I18n\Module::className(),
    ],
    'components' => [
//        'urlManager' => $params['app.urlManager'],
        'urlManager' => $params['app.urlManager.localeUrls'],
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
