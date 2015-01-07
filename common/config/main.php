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
        'assetManager' => [
            'bundles' => [
                // we will use bootstrap css from our theme
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [], // do not use yii default one
                ],
                // // use bootstrap js from CDN
                // 'yii\bootstrap\BootstrapPluginAsset' => [
                //     'sourcePath' => null,   // do not use file from our server
                //     'js' => [
                //         'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js']
                // ],
                // // use jquery from CDN
                // 'yii\web\JqueryAsset' => [
                //     'sourcePath' => null,   // do not use file from our server
                //     'js' => [
                //         '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                //     ]
                // ],
            ],
        ],
        'cache' => [
            'class' => yii\caching\FileCache::className(),
        ],
        'urlManager' => [
            'class' => yii\web\UrlManager::className(),
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
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
