<?php

namespace common\assets;

/**
 * Pace will automatically monitor your ajax requests, event loop lag,
 * document ready state, and elements on your page to decide the progress.
 * On ajax navigation it will begin again!
 *
 * @see http://github.hubspot.com/pace/
 */
class PaceAsset extends AssetBundle
{
    public $sourcePath = '@bower/pace';
    public $css = [
        'themes/blue/pace-theme-flash.css',
    ];
    public $js = [
        'pace.min.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}
