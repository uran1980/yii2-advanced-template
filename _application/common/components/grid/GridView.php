<?php

namespace common\components\grid;

use common\components\widgets\LinkPager;

class GridView extends \yii\grid\GridView
{
    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate [[columns]] objects.
     */
    public function init()
    {
        $this->dataColumnClass  = DataColumn::className();
        $this->layout           = "{summary}\n{pager}\n{items}\n{pager}";
        $this->showFooter       = true;
        $this->options = [
            'class' => 'grid-view table-responsive',
        ];
        $this->pager = [
            'class' => LinkPager::className(),
        ];

        parent::init();
    }
}
