<?php  // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/concept-configurations.md

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en',                                                         // default app language
    'components' => [
        'db'            => require(__DIR__ . '/multidb/db.php'),
        'dbLogger'      => require(__DIR__ . '/multidb/dbLogger.php'),
        'cache'         => $params['app.fileCache'],
        'mail'          => $params['app.mail'],
        'urlManager'    => $params['app.urlManager'],
        'assetManager'  => $params['app.assetManager'],
        'authManager'   => $params['app.authManager'],
        'i18n'          => $params['app.i18nModule'],
        'session' => [
            'class' => yii\web\DbSession::className(),
        ],
        'user' => [
            'class'             => yii\web\User::className(),
            'identityClass'     => common\models\UserIdentity::className(),
            'enableAutoLogin'   => true,
            'loginUrl'          => '/login',
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
