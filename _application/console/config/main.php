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
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'modules' => [
        // TODO
    ],
    'components' => [
        'i18n'      => $params['app.i18nModule'],
        'log' => [
            'targets' => [
                'file' => [
                    'class'     => yii\log\FileTarget::className(),
                    'levels'    => ['error', 'warning'],
                ],
                'dbLogger' => [
                    'class'   => common\components\log\AppLoggerDbTarget::className(),
                    'levels'  => ['info', 'error', 'warning'],
                    'logVars' => ['_GET', '_POST'],                             // @see yii2\log\Target.php
                    'categories' => [
                        AppLogger::CATEGORY_CONSOLE,
                    ],
                    'logTable' => 'log',
                ],
            ],
        ],
    ],
    'params' => $params,
];

// configuration adjustments for 'dev' environment
if (!YII_ENV_TEST && !YII_ENV_PROD) {
    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = $params['app.giiModule'];
}

return $config;
