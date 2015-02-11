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
        'common\assets\AppScrollToTopAsset',
        'common\assets\AppSpoilersAsset',
        'common\assets\AppChosenSelectAsset',

        'rmrevin\yii\fontawesome\AssetBundle',                                  // @see https://github.com/rmrevin/yii2-fontawesome
    ];
}
