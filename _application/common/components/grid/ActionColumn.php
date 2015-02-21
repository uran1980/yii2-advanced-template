<?php

namespace common\components\grid;

use Yii;
use yii\helpers\ArrayHelper;

class ActionColumn extends \yii\grid\ActionColumn
{
    public function init()
    {
        $this->header = Yii::t('common', 'Actions');
        $this->footer = Yii::t('common', 'Actions');
        $this->headerOptions = ArrayHelper::merge($this->headerOptions, [
            'class' => 'text-align-center',
            'width' => '100',
        ]);
        $this->footerOptions = ArrayHelper::merge($this->footerOptions, [
            'class' => 'text-align-center font-weight-bold th',
        ]);
        $this->contentOptions = ArrayHelper::merge($this->contentOptions, [
            'class' => 'text-align-center',
        ]);
    }
}
