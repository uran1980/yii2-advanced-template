<?php

namespace common\components\grid;

use yii\helpers\ArrayHelper;

class SerialColumn extends \yii\grid\SerialColumn
{
    public function init()
    {
        $this->header = 'ID';
        $this->footer = 'ID';
        $this->headerOptions = ArrayHelper::merge($this->headerOptions, [
            'class' => 'text-align-center',
            'width' => '30',
        ]);
        $this->footerOptions = ArrayHelper::merge($this->footerOptions, [
            'class' => 'text-align-center font-weight-bold th',
        ]);
        $this->contentOptions = ArrayHelper::merge($this->contentOptions, [
            'class' => 'text-align-center',
        ]);

        parent::init();
    }
}
