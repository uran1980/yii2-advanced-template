<?php

namespace common\assets;

/**
 * The scroll monitor allows you to receive events when elements enter or exit
 * the viewport. It does this using watcher objects, which watch an element and
 * trigger events. Watcher objects also contain information about the element
 * they watch, including the element's visibility and location relative to the viewport.
 *
 * @see https://github.com/sakabako/scrollMonitor
 */
class ScrollMonitorAsset extends AssetBundle
{
    public $sourcePath = '@bower/scrollMonitor';
    public $js = [
        'scrollMonitor.js',
    ];
}
