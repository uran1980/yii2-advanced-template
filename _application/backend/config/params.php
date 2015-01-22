<?php

use \yii\web\View;

/**
 * @var string $theme - app theme name
 */
$theme = 'default';

$config = [
    // ----------------------- URL MANAGER COMPONENT ---------------------------
    // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/url.md
    'app.urlManager' => [
        'rules' => [
            ''      => 'backend/index/index',
            '/home' => 'backend/index/index',

            // @see http://www.elisdn.ru/blog/62/seo-service-on-yii2-ide-and-modules
            '<_a:(backend|dashbord|admin)>'             => 'backend/index/index',
            '<_a:error>'                                => 'backend/index/<_a>',
            '<_a:(index|login|logout)>'                 => 'backend/index/<_a>',

            '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>'    => '<_m>/<_c>/<_a>',
            '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>'        => '<_m>/<_c>/view',
            '<_m:[\w\-]+>'                              => '<_m>/index/index',
            '<_m:[\w\-]+>/<_a:[\w\-]+>'                 => '<_m>/index/<_a>',
            '<_m:[\w\-]+>/<_c:[\w\-]+>'                 => '<_m>/<_c>/index',

            '<_c:[\w\-]+>'                              => 'backend/<_c>/index',
            '<_c:[\w\-]+>/<_a:[\w\-]+>'                 => 'backend/<_c>/<_a>',
        ],
    ],
    'app.urlManagerFrontend' => [
        'class'             => yii\web\UrlManager::className(),
        'enablePrettyUrl'   => true,
        'showScriptName'    => false,
        'baseUrl'           => '/../',
    ],

    // -------------------------- VIEW COMPONENT -------------------------------
    'app.view' => [
        // here you can set theme used for your backend application
        // - template comes with: 'default', 'slate', 'spacelab' and 'cerulean'
        'theme' => [
            'pathMap' => [
                '@Zelenin/yii/modules/I18n/views' => '@common/modules/i18n/views',
            ],
            'baseUrl'  => "@web/themes/$theme",
            'basePath' => "@webroot/themes/$theme",
        ],
    ],
];
$config['app.urlManager.localeUrls']['rules'] = $config['app.urlManager']['rules'];

// --------------------------- MINIFY VIEW COMPONET ----------------------------
// @see https://github.com/rmrevin/yii2-minify-view
if ( YII_ENV_PROD || YII_ENV == 'staging' ) {
    $config['app.view'] = array_merge(
        $config['app.view'],
        [
            'class'          => common\components\minify\View::className(),
            'base_path'      => '@webroot',
            'minify_path'    => "@webroot/themes/$theme/compiled",
            'force_charset'  => 'UTF-8',
            'expand_imports' => true,
            'js_position' => [
                View::POS_END,
            ],
        ]
    );
}

return $config;
