<?php

namespace common\assets;

class DebugPanelAsset extends AssetBundle
{
    public $sourcePath = '@common/web';
    public $depends = [
        'yii\debug\DebugAsset',
        'common\assets\CommonAsset',
    ];
}
