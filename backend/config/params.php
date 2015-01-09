<?php

$config = [
    // ----------------------- URL MANAGER COMPONENT ---------------------------
    // @see https://github.com/yiisoft/yii2/blob/master/docs/guide/url.md
    'app.urlManager' => [
        'class' => yii\web\UrlManager::className(),
        'rules' => [
            ''      => 'backend/index/index',
            '/home' => 'backend/index/index',
            '/login' => 'backend/index/login',

            // @see http://www.elisdn.ru/blog/62/seo-service-on-yii2-ide-and-modules
            '<_a:error>'                                => 'backend/index/<_a>',
            'backend/<_a:(index|login|logout)>'        => 'backend/index/<_a>',

            '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>'    => '<_m>/<_c>/<_a>',
        ],
    ],
];

return $config;
