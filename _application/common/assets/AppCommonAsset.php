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
        'common\assets\PaceAsset',
        'common\assets\AppScrollToTopAsset',
        'common\assets\AppSpoilersAsset',
        'common\assets\AppChosenSelectAsset',
        'common\assets\AppAjaxButtonsAsset',
        'common\assets\AppIGrowlAsset',

        'rmrevin\yii\fontawesome\AssetBundle',                                  // @see https://github.com/rmrevin/yii2-fontawesome
        'common\assets\JqueryCookieAsset',
        'common\assets\FancyboxAsset',
    ];
}
