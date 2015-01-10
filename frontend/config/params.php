<?php

$config = [
    // ----------------------- URL MANAGER COMPONENT ---------------------------
    // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/url.md
    'app.urlManager' => [
        'rules' => [
            ''              => 'site/index/index',
            '/home'         => 'site/index/index',
            '/articles'      => 'site/article/index',

            // @see http://www.elisdn.ru/blog/62/seo-service-on-yii2-ide-and-modules
            '<_a:(error|index|about|contact|captcha)>'                                  => 'site/index/<_a>',
            '/profile/<_a:(login|logout|signup|request-password-reset|reset-password)>' => 'profile/index/<_a>',
            '<_a:(login|logout|signup|request-password-reset|reset-password)>'          => 'profile/index/<_a>',

            '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>'    => '<_m>/<_c>/<_a>',
            '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>'        => '<_m>/<_c>/view',
            '<_m:[\w\-]+>'                              => '<_m>/index/index',
            '<_m:[\w\-]+>/<_a:[\w\-]+>'                 => '<_m>/index/<_a>',
            '<_m:[\w\-]+>/<_c:[\w\-]+>'                 => '<_m>/<_c>/index',
        ],
    ],
];
$config['app.urlManager.localeUrls']['rules'] = $config['app.urlManager']['rules'];

return $config;