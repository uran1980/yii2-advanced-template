<?php

/**
 * Application configuration for backend unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/_application/common/config/main.php'),
    require(YII_APP_BASE_PATH . '/_application/common/config/main-local.php'),
    require(YII_APP_BASE_PATH . '/_application/backend/config/main.php'),
    require(YII_APP_BASE_PATH . '/_application/backend/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/unit.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
