<?php

namespace common\assets;

class AppSpoilersAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $js = [
        'js/app-spoilers.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
