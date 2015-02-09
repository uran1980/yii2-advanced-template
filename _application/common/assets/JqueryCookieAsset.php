<?php

namespace common\assets;

class JqueryCookieAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-cookie';
    public $js = [
        'jquery.cookie.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
