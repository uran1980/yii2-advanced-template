<?php

namespace common\assets;

class ScrollToTopAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/bower/scroll-to-top';
    public $css = [
        'style.css',
    ];
    public $js = [
        'jquery.scrollToTop.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
