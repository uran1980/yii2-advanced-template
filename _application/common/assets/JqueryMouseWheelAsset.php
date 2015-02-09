<?php

namespace common\assets;

class JqueryMouseWheelAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-mousewheel';
    public $js = [
        'jquery.mousewheel.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
