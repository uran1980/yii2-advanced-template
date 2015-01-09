<?php

namespace common\components\web;

//use codemix\localeurls\UrlManager;
use yii\web\UrlManager;
use common\components\log\AppLogger;

/**
 * @see https://github.com/codemix/yii2-localeurls
 */
class AppUrlManager extends UrlManager
{
    /**
     * Adds language functionality to URL creation
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        $url = parent::createUrl($params);

//        // debug info ----------------------------------------------------------
//        AppLogger::log(array(
//            'method'    => __METHOD__,
//            'line'      => __LINE__,
//            '$params'   => $params,
//            '$url'      => $url,
//        ), AppLogger::INFO, AppLogger::CATEGORY_TEST);
//        // ---------------------------------------------------------------------

        return $url;
    }
}
