<?php

namespace common\assets;

/**
 * @see http://imsky.github.io/holder/
 */
class HolderjsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/holderjs';
    public $js = [
        'holder.js',
    ];
}
