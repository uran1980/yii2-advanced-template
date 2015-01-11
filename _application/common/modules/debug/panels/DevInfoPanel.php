<?php

namespace common\modules\debug\panels;

use Yii;
use yii\debug\Panel;

class DevInfoPanel extends Panel
{
    /**
     * return string
     */
    public function getName()
    {
        return 'DevInfo';
    }

    /**
     * return string
     */
    public function getSummary()
    {
        return Yii::$app->view->render('@common/modules/debug/views/default/panels/dev-info/summary', [
            'panel' => $this,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return Yii::$app->view->render('@common/modules/debug/views/default/panels/dev-info/detail', [
            'panel' => $this,
        ]);
    }

    /**
     * return array
     */
    public function save()
    {
        return [
            'aliases' => Yii::$aliases,
        ];
    }

}
