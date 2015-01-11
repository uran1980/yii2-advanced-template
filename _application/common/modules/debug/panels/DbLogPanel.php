<?php

namespace common\modules\debug\panels;

use Yii;
use yii\debug\Panel;
use yii\log\Logger;
use common\modules\debug\models\search\DbLog;
use common\models\Log;

class DbLogPanel extends Panel
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'DbLogs';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Yii::$app->view->render('@common/modules/debug/views/default/panels/db-log/summary', [
            'totalCount'    => Log::getTotalCount(),
            'errorCount'    => Log::getErrorCount(),
            'warningCount'  => Log::getWarningCount(),
            'panel'         => $this,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        $searchModel = new DbLog();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return Yii::$app->view->render('@common/modules/debug/views/default/panels/db-log/detail', [
            'dataProvider'  => $dataProvider,
            'panel'         => $this,
            'searchModel'   => $searchModel,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $target = $this->module->logTarget;
        $messages = $target->filterMessages($target->messages, Logger::LEVEL_ERROR | Logger::LEVEL_INFO | Logger::LEVEL_WARNING | Logger::LEVEL_TRACE);
        return ['messages' => $messages];
    }

}
