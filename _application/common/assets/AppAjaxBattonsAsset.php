<?php

namespace common\assets;

class AppAjaxBattonsAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $js = [
        'js/app-ajax-battons.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'rmrevin\yii\fontawesome\AssetBundle',                                  // @see https://github.com/rmrevin/yii2-fontawesome
        'common\assets\AppIGrowlAsset',
    ];
}
