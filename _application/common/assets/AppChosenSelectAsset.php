<?php

namespace common\assets;

class AppChosenSelectAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $js = [
        'js/app-chosen-select.js',
    ];
    public $depends = [
        'common\assets\ChosenSelectAsset',
    ];
}
