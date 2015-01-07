<?php

namespace common\components\log;

use Yii;

class AppLogger
{
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const INFO      = 'info';
    const TRACE     = 'trace';

    const CATEGORY_APPLICATION  = 'application';
    const CATEGORY_FRONTEND     = 'frontend';
    const CATEGORY_SITE         = 'site';
    const CATEGORY_PROFILE      = 'profile';
    const CATEGORY_BACKEND      = 'backend';
    const CATEGORY_COMMON       = 'common';
    const CATEGORY_TEST         = 'test';
    const CATEGORY_CONSOLE      = 'console';

    /**
     * Logs a message with the given type and category.
     * If [[traceLevel]] is greater than 0, additional call stack information about
     * the application code will be logged as well.
     *
     * @param string|array $message the message to be logged. This can be a simple string or a more
     *                              complex data structure that will be handled by a [[Target|log target]].
     * @param integer $level the level of the message. This must be one of the following:
     *                       `Logger::LEVEL_ERROR`, `Logger::LEVEL_WARNING`, `Logger::LEVEL_INFO`, `Logger::LEVEL_TRACE`,
     *                       `Logger::LEVEL_PROFILE_BEGIN`, `Logger::LEVEL_PROFILE_END`.
     * @param string $category the category of the message.
     */
    public static function log($message, $level = 'info', $category = 'application')
    {
        if ( !is_string($message) ) {
            $message = print_r($message, true);
        }

        switch ($level) {
            case self::ERROR:
                Yii::error($message, $category);
                break;

            case self::WARNING:
                Yii::warning($message, $category);
                break;

            case self::TRACE:
                Yii::trace($message, $category);
                break;

            case self::INFO:
            default:
                Yii::info($message, $category);
                break;
        }
    }

    /**
     * Aliase for Yii::info()
     *
     * @param string $message
     * @param string $category
     */
    public static function info($message, $category = 'application')
    {
        self::log($message, self::INFO, $category);
    }

    /**
     * Aliase for Yii::error()
     *
     * @param string $message
     * @param string $category
     */
    public static function error($message, $category = 'application')
    {
        self::log($message, self::ERROR, $category);
    }

    /**
     * Aliase for Yii::warning()
     *
     * @param string $message
     * @param string $category
     */
    public static function warning($message, $category = 'application')
    {
        self::log($message, self::WARNING, $category);
    }

    /**
     * Aliase for Yii::trace()
     *
     * @param string $message
     * @param string $category
     */
    public static function trace($message, $category = 'application')
    {
        self::log($message, self::TRACE, $category);
    }

}
