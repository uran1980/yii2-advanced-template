<?php

use \yii\web\View;

$config = [

//------------------------//
// SYSTEM SETTINGS
//------------------------//

    /**
     * Registration Needs Activation.
     *
     * If set to true users will have to activate their profile using email profile activation.
     */
    'RegistrationNeedsActivation' => false,

    /**
     * Login With Email.
     *
     * If set to true users will have to login using email/password combo.
     */
    'LoginWithEmail' => false,

    /**
     * Force Strong Password.
     *
     * If set to true users will have to use passwords with strength determined by StrengthValidator.
     */
    'ForceStrongPassword' => false,

    /**
     * Set the password reset token expiration time.
     */
    'user.passwordResetTokenExpire' => 3600,

//------------------------//
// EMAILS
//------------------------//

    /**
     * Email used in contact form.
     * Users will send you emails to this address.
     */
    'adminEmail' => 'admin@example.com',

    /**
     * Not used in template.
     * You can set support email here.
     */
    'supportEmail' => 'support@example.com',


    // ----------------------- URL MANAGER COMPONENT ---------------------------
    // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/url.md
    'app.urlManager' => [
        'class'             => common\components\web\AppUrlManager::className(),
        'enablePrettyUrl'   => true,
        'showScriptName'    => false,                                           // false - means that index.php will not be part of the URLs
    ],

    // ---------------------------- GII MODULE ---------------------------------
    // @see http://www.yiiframework.com/doc-2.0/guide-tool-gii.html
    'app.giiModule' => [
        'class'      => yii\gii\Module::className(),
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*'],
    ],

    // -------------------------- CACHE COMPONENT ------------------------------
    // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/caching.md
    'app.fileCache' => [
        'class' => yii\caching\FileCache::className(),
    ],

    // ------------------------ MINIFY VIEW COMPONET ---------------------------
    // @see https://github.com/rmrevin/yii2-minify-view
    'app.minifyView' => [
        'class'          => rmrevin\yii\minify\View::className(),
        'base_path'      => '@webroot',
        'minify_path'    => '@webroot/compiled',
        'force_charset'  => 'UTF-8',
        'expand_imports' => true,
        'js_position' => [
            View::POS_END,
        ],
    ],

    // ------------------- ASSET MANAGER COMPONENT -----------------------------
    // @see http://stackoverflow.com/questions/25850164/yii2-asset-convertor
    // @see vendor\yiisoft\yii2\web\AssetConverter.php
    'app.assetManager' => [
//        'forceCopy' => YII_ENV_DEV,
        'bundles' => [
            // we will use bootstrap css from our theme
            'yii\bootstrap\BootstrapAsset' => [
                'css' => [], // do not use yii default one
            ],
//             // use bootstrap js from CDN
//             'yii\bootstrap\BootstrapPluginAsset' => [
//                 'sourcePath' => null,   // do not use file from our server
//                 'js' => [
//                     'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js']
//             ],
//             // use jquery from CDN
//             'yii\web\JqueryAsset' => [
//                 'sourcePath' => null,   // do not use file from our server
//                 'js' => [
//                     '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
//                 ]
//             ],
        ],
        'converter' => [
            'class' => common\assets\AppAssetConvertor::className(),
//            'forceConvert'  => YII_ENV_DEV,
        ],
    ],

    // ---------------------------- DEBUG MODULE -------------------------------
    'app.debugModule' => [
        'class' => yii\debug\Module::className(),
        'controllerMap' => [
            'default' => common\modules\debug\controllers\DefaultController::className(),
        ],
        'panels' => [
            'log' => [
                'class' => common\modules\debug\panels\LogPanel::className(),
            ],
            'dbLogs' => [
                'class' => common\modules\debug\panels\DbLogPanel::className(),
            ],
            'views' => [
                'class' => common\modules\debug\panels\ViewsPanel::className(),
            ],
            'devInfo' => [
                'class' => common\modules\debug\panels\DevInfoPanel::className(),
            ],
        ],
    ],
];

return $config;
