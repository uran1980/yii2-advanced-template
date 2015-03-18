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
        'uran1980\yii\assets\jQueryEssential\JqueryEssentialAsset',
    ];
}
