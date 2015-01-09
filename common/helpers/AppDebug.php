<?php

namespace common\helpers;

use yii\helpers\VarDumper;

class AppDebug extends VarDumper
{
    /**
     * Displays a variable.
     * This method achieves the similar functionality as var_dump and print_r
     * but is more robust when handling complex objects such as Yii controllers.
     *
     * @param mixed   $var       variable to be dumped
     * @param integer $depth     maximum depth that the dumper should go into the variable. Defaults to 10.
     * @param boolean $highlight whether the result should be syntax-highlighted
     * @param bool    $pre
     * @return string
     */
    public static function dump($var, $depth = 10, $highlight = false, $pre = true)
    {
        $output = '';

        if ( YII_ENV == 'prod' )
            return $output;

        if ($depth == 'text' || $depth == 'console') {
            $pre = false;
        } else if ($depth == 'html') {
            $pre = true;
        }

        if ( !is_numeric($depth) )
            $depth = 10;

        if (true === $pre) {
            $output .= '<pre>';
            $output .= static::dumpAsString($var, $depth, $highlight);
            $output .= '</pre>';
        } else {
            $output .= static::dumpAsString($var, $depth, $highlight);
        }

        echo $output;
    }
}
