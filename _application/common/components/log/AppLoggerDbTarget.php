<?php

namespace common\components\log;

use yii\log\DbTarget;

/**
 * @see https://github.com/yiisoft/yii2/blob/master/docs/guide/runtime-logging.md#log-targets
 */
class AppLoggerDbTarget extends DbTarget
{
    /**
     * @var Connection|string the DB connection object or the application component ID of the DB connection.
     * After the DbTarget object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     */
    public $db = 'dbLogger';

}
