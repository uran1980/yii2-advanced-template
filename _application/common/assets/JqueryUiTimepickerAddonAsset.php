<?php

namespace common\assets;

class JqueryUiTimepickerAddonAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/jqueryui-timepicker-addon/dist';
    public $css = [
        'jquery-ui-timepicker-addon.min.css',
    ];
    public $js = [
        'jquery-ui-timepicker-addon.min.js',
    ];
    public $depends = [
        'common\assets\JqueryUiAsset',
    ];
}
