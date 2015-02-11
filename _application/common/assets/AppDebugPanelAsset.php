<?php

namespace common\assets;

class AppDebugPanelAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $depends = [
        'yii\debug\DebugAsset',
        'common\assets\AppCommonAsset',
    ];
}
