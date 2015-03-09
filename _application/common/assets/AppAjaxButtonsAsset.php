<?php

namespace common\assets;

class AppAjaxButtonsAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $js = [
        'js/app-ajax-buttons.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'uran1980\yii\widgets\igrowl\IgrowlAsset',
    ];
}
