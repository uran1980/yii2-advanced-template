<?php

namespace common\assets;

class JqueryEasingAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.easing/js';
    public $js = [
        'jquery.easing.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
