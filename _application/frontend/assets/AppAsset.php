<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

class AppAsset extends AssetBundle
{
    // @see vendor\yiisoft\yii2\base\Theme.php
    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',

        'common\assets\AppCommonAsset',
        'uran1980\yii\assets\codePrettify\CodePrettifyAsset',
    ];
}
