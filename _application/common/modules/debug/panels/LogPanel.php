<?php

namespace common\modules\debug\panels;

use Yii;
use common\modules\debug\models\search\Log;

class LogPanel extends \yii\debug\panels\LogPanel
{
    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        $searchModel    = new Log();
        $dataProvider   = $searchModel->search(Yii::$app->request->getQueryParams(), $this->getModels());

        return Yii::$app->view->render('@common/modules/debug/views/default/panels/db-log/detail', [
            'dataProvider'  => $dataProvider,
            'panel'         => $this,
            'searchModel'   => $searchModel,
        ]);
    }
}
