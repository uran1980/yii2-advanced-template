<?php

namespace backend\assets;

use common\assets\AssetBundle;

class AppTranslateAsset extends AssetBundle
{
    public $sourcePath = '@backend/web';
    public $js = [
        'js/app-translate.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\AppIGrowlAsset',
        'common\assets\AppAjaxButtonsAsset',
    ];
}
