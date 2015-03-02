<?php

namespace backend\assets;

use common\assets\AssetBundle;

class AppTranslateAsset extends AssetBundle
{
    public $sourcePath = '@backend/web';
    public $css = [
        'scss/translate.scss',
    ];
    public $js = [
        'js/translate.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\AppIGrowlAsset',
        'common\assets\AppAjaxButtonsAsset',
        'backend\assets\AppAsset',
    ];
}
