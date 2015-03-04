<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)));

defined('FRONTEND_ENTRY_FILE') or define('FRONTEND_ENTRY_FILE',
    YII_APP_BASE_PATH . '/../index-test.php');

defined('FRONTEND_ENTRY_URL') or define('FRONTEND_ENTRY_URL', 'http://localhost:8080/backend/index-test.php');

require_once(YII_APP_BASE_PATH . '/vendor/autoload.php');
require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once(YII_APP_BASE_PATH . '/_application/common/config/bootstrap.php');
require_once(YII_APP_BASE_PATH . '/_application/frontend/config/bootstrap.php');

// set correct script paths
// the entry script file path for functional and acceptance tests
$_SERVER['SCRIPT_FILENAME'] = FRONTEND_ENTRY_FILE;
$_SERVER['SCRIPT_NAME']     = FRONTEND_ENTRY_URL;

Yii::setAlias('@tests', __DIR__ . '/../../_application/tests');

$config = require(__DIR__ . '/../../_application/tests/codeception/config/frontend/acceptance.php');

new yii\web\Application($config);
