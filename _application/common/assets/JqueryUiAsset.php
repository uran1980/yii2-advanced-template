<?php

namespace common\assets;

class JqueryUiAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';
    public $css = [
        'themes\smoothness\jquery-ui.min.css',
    ];
    public $js = [
        'jquery-ui.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
