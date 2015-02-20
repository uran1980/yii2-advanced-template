<?php

namespace common\assets;

class FancyboxAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/fancybox/source';
    public $css = [
        'jquery.fancybox.css',
    ];
    public $js = [
        'jquery.fancybox.pack.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\JqueryEasingAsset',
        'common\assets\JqueryMouseWheelAsset',
    ];
}
