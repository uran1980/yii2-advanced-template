<?php

namespace common\assets;

class AppIGrowlAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $css = [
        'css/app-igrowl.css',
    ];
    public $depends = [
        'common\assets\IgrowlAsset',
    ];
}
