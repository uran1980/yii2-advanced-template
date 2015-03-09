<?php

namespace backend\modules\backend\controllers;

use common\components\controllers\BackendController;

/**
 * Application Logs Index controller
 */
class ApplicationLogsController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}