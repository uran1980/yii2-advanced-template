<?php

namespace common\assets;

class AppScrollToTopAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $js = [
        'js/app-scroll-to-top.js',
    ];
    public $depends = [
        'common\assets\ScrollToTopAsset',
    ];
}
