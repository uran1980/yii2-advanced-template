<?php

namespace common\assets;

class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * Registers the CSS and JS files with the given view.
     * @param \yii\web\View $view the view that the asset files are to be registered with.
     */
    public function registerAssetFiles($view)
    {
        $manager = $view->getAssetManager();
        foreach ($this->js as $js) {
            $view->registerJsFile($manager->getAssetUrl($this, $js), $this->jsOptions);
        }
        foreach ($this->css as $css) {
            // FIX -------------------------------------------------------------
            // save converted files in to css folder instead of scss
            $pos = strrpos($css, '.');
            $ext = ($pos !== false) ? substr($css, $pos + 1) : null;
            if ( $ext == 'css' ) {
                $css = preg_replace("/^scss\//i", "css/", $css);
            }
            // -----------------------------------------------------------------

            $view->registerCssFile($manager->getAssetUrl($this, $css), $this->cssOptions);
        }
    }
}
