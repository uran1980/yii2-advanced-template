<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@themes';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',

        'common\assets\AppCommonAsset',
    ];
}
