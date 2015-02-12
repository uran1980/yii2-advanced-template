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
        'rules' => require(__DIR__ . '/routes.php'),
    ],
    'app.urlManagerBackend' => [
        'class'             => yii\web\UrlManager::className(),
        'enablePrettyUrl'   => true,
        'showScriptName'    => false,
        'baseUrl'           => '/backend',
    ],

    // -------------------------- VIEW COMPONENT -------------------------------
    'app.view' => [
        // here you can set theme used for your frontend application
        // - template comes with: 'default', 'slate', 'spacelab' and 'cerulean'
        'theme' => [
            'pathMap' => [
                // TODO
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