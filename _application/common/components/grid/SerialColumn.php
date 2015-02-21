<?php

namespace common\components\grid;

class SerialColumn extends \yii\grid\SerialColumn
{
    public function init()
    {
        $this->header = 'ID';
        $this->footer = 'ID';
        $this->headerOptions = [
            'class' => 'text-align-center',
            'width' => '30',
        ];
        $this->footerOptions = [
            'class' => 'text-align-center font-weight-bold th',
        ];
        $this->contentOptions = [
            'class' => 'text-align-center',
        ];
    }
}
