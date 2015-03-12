<?php

return [
    ''                                  => 'site/index/index',
    '/home'                             => 'site/index/index',
    '/articles'                         => 'site/article/index',
    '/articles/<_a:[\w\-]+>/<id:\d+>'   => 'site/article/<_a>',
    '/articles/<_a:[\w\-]+>'            => 'site/article/<_a>',
    '/profile'                          => 'profile/index/index',

    // @see http://www.elisdn.ru/blog/62/seo-service-on-yii2-ide-and-modules
    '<_a:(error|index|about|contact|captcha)>'                                  => 'site/index/<_a>',
    '/profile/<_a:(login|logout|signup|request-password-reset|reset-password)>' => 'profile/index/<_a>',
    '<_a:(login|logout|signup|request-password-reset|reset-password)>'          => 'profile/index/<_a>',

    '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/page/<page:\d+>'                    => '<_m>/<_c>/<_a>',
    '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>'                                    => '<_m>/<_c>/<_a>',
    '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>'                                        => '<_m>/<_c>/view',
    '<_m:[\w\-]+>'                                                              => '<_m>/index/index',
    '<_m:[\w\-]+>/<_a:[\w\-]+>'                                                 => '<_m>/index/<_a>',
    '<_m:[\w\-]+>/<_c:[\w\-]+>'                                                 => '<_m>/<_c>/index',
];