<?php

namespace common\assets;

class AppCommonAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $css = [
        'scss/basemod-classes.scss',
        'scss/common.scss',
    ];
    public $js = [
        'js/common.js',
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',                                  // @see https://github.com/rmrevin/yii2-fontawesome
        'common\assets\ScrollToTopAsset',
    ];
}
