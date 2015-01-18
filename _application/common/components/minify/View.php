<?php

namespace common\components\minify;

use yii\helpers;

class View extends \rmrevin\yii\minify\View
{
    /**
     * @return self
     */
    protected function minifyCSS()
    {
        if (!empty($this->cssFiles)) {
            $css_files = array_keys($this->cssFiles);

            $css_minify_file = $this->minify_path . '/' . $this->_getSummaryFilesHash($this->cssFiles) . '.css';
            if (!file_exists($css_minify_file)) {
                $css = '';

                foreach ($css_files as $file) {
                    $content = file_get_contents($this->getBasePath() . $file);

                    preg_match_all('|url\(([^)]+)\)|is', $content, $m);
                    if (!empty($m[0])) {
                        $path = dirname($file);
                        $result = [];
                        foreach ($m[0] as $k => $v) {
                            if (0 === strpos($m[1][$k], 'data:')) {
                                continue;
                            }
                            $url = str_replace(['\'', '"'], '', $m[1][$k]);
                            if (preg_match('#^(' . implode('|', $this->schemas) . ')#is', $url)) {
                                $result[$m[1][$k]] = '\'' . $url . '\'';
                            } else {
                                $result[$m[1][$k]] = '\'' . $path . '/' . $url . '\'';
                            }
                        }
                        $content = str_replace(array_keys($result), array_values($result), $content);
                    }

                    $css .= $content;
                }

                $this->expandImports($css);

                $css = (new \CSSmin())->run($css, $this->css_linebreak_pos);

                if (false !== $this->force_charset) {
                    $charsets = '@charset "' . (string)$this->force_charset . '";' . "\n";
                } else {
                    $charsets = $this->collectCharsets($css);
                }

                $imports = $this->collectImports($css);
                $fonts = $this->collectFonts($css);

                file_put_contents($css_minify_file, $charsets . $imports . $fonts . $css);
                if (false !== $this->file_mode) {
                    chmod($css_minify_file, $this->file_mode);
                }
            }

//            // debug info ------------------------------------------------------
//            \common\components\log\AppLogger::info(array(
//                'method'                => __METHOD__,
//                'line'                  => __LINE__,
//                '$this->base_path'      => $this->base_path,
//                'alias'                 => $this->getBasePath(),
//                '$this->minify_path'    => $this->minify_path,
//                '$css_minify_file'      => $css_minify_file,
//            ));
//            // -----------------------------------------------------------------

            $css_file = str_replace($this->getBasePath(), '', $css_minify_file);
            $this->cssFiles = [$css_file => helpers\Html::cssFile($css_file)];
        }

        return $this;
    }

    /**
     * @return self
     */
    protected function minifyJS()
    {
        if (!empty($this->jsFiles)) {
            $js_files = $this->jsFiles;
            foreach ($js_files as $position => $files) {
                if (false === in_array($position, $this->js_position)) {
                    $this->jsFiles[$position] = [];
                    foreach ($files as $file => $html) {
                        $this->jsFiles[$position][$file] = helpers\Html::jsFile($file);
                    }
                } else {
                    $this->jsFiles[$position] = [];

                    $js_minify_file = $this->minify_path . '/' . $this->_getSummaryFilesHash($files) . '.js';
                    if (!file_exists($js_minify_file)) {
                        $js = '';
                        foreach ($files as $file => $html) {
                            $file = $this->getBasePath() . $file;
                            $js .= file_get_contents($file) . ';' . PHP_EOL;
                        }

                        $js = (new \JSMin($js))->min();

                        file_put_contents($js_minify_file, $js);
                        if (false !== $this->file_mode) {
                            chmod($js_minify_file, $this->file_mode);
                        }
                    }

                    $js_file = str_replace($this->getBasePath(), '', $js_minify_file);
                    $this->jsFiles[$position][$js_file] = helpers\Html::jsFile($js_file);
                }
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getBasePath()
    {
        $output = preg_replace("#/backend$#i", '', \Yii::getAlias($this->base_path));

//        // debug info ----------------------------------------------------------
//        \common\components\log\AppLogger::info(array(
//            'method'                => __METHOD__,
//            'line'                  => __LINE__,
//            '$this->base_path'      => $this->base_path,
//            'alias'                 => \Yii::getAlias($this->base_path),
//            '$this->minify_path'    => $this->minify_path,
//        ));
//        // ---------------------------------------------------------------------

        return $output;
    }

    /**
     * @param array $files
     * @return string
     */
    private function _getSummaryFilesHash($files)
    {
        $result = '';
        foreach ($files as $file => $html) {
            $result .= sha1_file($this->getBasePath() . $file);
        }

        return sha1($result);
    }

    /**
     * @param string $css
     */
    private function expandImports(&$css)
    {
        if (true === $this->expand_imports) {
            preg_match_all('|\@import\s([^;]+);|is', str_replace('&amp;', '&', $css), $m);
            if (!empty($m[0])) {
                foreach ($m[0] as $k => $v) {
                    $import_url = $m[1][$k];
                    if (!empty($import_url)) {
                        $import_content = $this->getImportContent($import_url);
                        if (!empty($import_content)) {
                            $css = str_replace($m[0][$k], $import_content, $css);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $url
     * @return null|string
     */
    private function getImportContent($url)
    {
        $result = null;

        if ('url(' === helpers\StringHelper::byteSubstr($url, 0, 4)) {
            $url = str_replace(['url(\'', 'url("', 'url(', '\')', '")', ')'], '', $url);

            if (helpers\StringHelper::byteSubstr($url, 0, 2) === '//') {
                $url = preg_replace('|^//|', 'http://', $url, 1);
            }

            if (!empty($url)) {
                $result = file_get_contents($url);
            }
        }

        return $result;
    }

    /**
     * @param string $css
     * @param string $pattern
     * @param callable $handler
     * @return string
     */
    private function _collect(&$css, $pattern, $handler)
    {
        $result = '';

        preg_match_all($pattern, $css, $m);
        foreach ($m[0] as $string) {
            $string = $handler($string);
            $css = str_replace($string, '', $css);

            $result .= $string . PHP_EOL;
        }

        return $result;
    }

    /**
     * @param string $css
     * @return string
     */
    private function collectCharsets(&$css)
    {
        return $this->_collect($css, '|\@charset[^;]+|is', function ($string) {
            return $string . ';';
        });
    }

    /**
     * @param string $css
     * @return string
     */
    private function collectImports(&$css)
    {
        return $this->_collect($css, '|\@import[^;]+|is', function ($string) {
            return $string . ';';
        });
    }

    /**
     * @param string $css
     * @return string
     */
    private function collectFonts(&$css)
    {
        return $this->_collect($css, '|\@font-face\{[^}]+\}|is', function ($string) {
            return $string;
        });
    }
}
