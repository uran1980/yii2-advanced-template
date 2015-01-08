<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'name' => 'My Company',
//    'language' => 'en',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'assetManager' => $params['app.assetManager'],
        'cache' => [
            'class' => yii\caching\FileCache::className(),
        ],
        'urlManager' => $params['app.urlManager'],
        'session' => [
            'class' => yii\web\DbSession::className(),
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::className(),
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
    ], // components
];

if ( YII_ENV_PROD || YII_ENV == 'staging' ) {
    $config['components']['view'] = $params['app.minifyView'];
}

// configuration adjustments for 'dev' environment
if (!YII_ENV_TEST && !YII_ENV_PROD) {
    $config['bootstrap'][]      = 'debug';
    $config['bootstrap'][]      = 'gii';
    $config['modules']['debug'] = $params['app.debugModule'];
    $config['modules']['gii']   = $params['app.giiModule'];
}

return $config;
