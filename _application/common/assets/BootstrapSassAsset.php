<?php
namespace common\assets;

class BootstrapSassAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/bootstrap-sass-official/assets/stylesheets';
    public $css = [
        'css/bootstrap.scss',
    ];
}
