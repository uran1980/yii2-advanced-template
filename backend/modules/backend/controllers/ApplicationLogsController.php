<?php

namespace backend\modules\backend\controllers;

use Yii;
use common\components\controllers\BackendController;
use common\modules\debug\models\search\DbLog;

/**
 * Index controller
 */
class ApplicationLogsController extends BackendController
{
    public function actionIndex()
    {
        $searchModel  = new DbLog();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider'  => $dataProvider,
            'searchModel'   => $searchModel,
        ]);
    }
}