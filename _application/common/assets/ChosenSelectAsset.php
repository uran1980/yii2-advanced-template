<?php

namespace common\assets;

/**
 * @see https://github.com/harvesthq/chosen
 * @see http://harvesthq.github.io/chosen/
 */
class ChosenSelectAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/web/bower/chosen_v1.3.0';
    public $css = [
        'chosen.min.css',
    ];
    public $js = [
        'chosen.jquery.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
