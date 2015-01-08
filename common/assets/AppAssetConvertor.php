<?php

namespace common\assets;

use yii\web\AssetConverter;

class AppAssetConvertor extends AssetConverter
{
    /**
     * Converts a given asset file into a CSS or JS file.
     * @param string $asset the asset file path, relative to $basePath
     * @param string $basePath the directory the $asset is relative to.
     * @return string the converted asset file path, relative to $basePath.
     */
    public function convert($asset, $basePath)
    {
        $pos = strrpos($asset, '.');
        if ($pos !== false) {
            $ext = substr($asset, $pos + 1);
            if (isset($this->commands[$ext])) {
                list ($ext, $command) = $this->commands[$ext];
                $result = substr($asset, 0, $pos + 1) . $ext;

                // FIX ---------------------------------------------------------
                // save converted files in to css folder
                if ( $ext == 'css' ) {
                    $result = preg_replace("/^scss\//i", "css/", $result);
                }
                // -------------------------------------------------------------

                if ($this->forceConvert || @filemtime("$basePath/$result") < @filemtime("$basePath/$asset")) {
                    $this->runCommand($command, $basePath, $asset, $result);
                }

                return $result;
            }
        }

        return $asset;
    }
}
