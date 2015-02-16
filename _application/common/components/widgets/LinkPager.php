<?php

namespace common\components\widgets;

use Yii;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * Initializes the pager.
     */
    public function init()
    {
        $this->nextPageLabel  = Yii::t('paginator', 'Next') . ' &raquo;';
        $this->prevPageLabel  = '&laquo; ' . Yii::t('paginator', 'Prev.');
        $this->firstPageLabel = Yii::t('paginator', 'First');
        $this->lastPageLabel  = Yii::t('paginator', 'Last');

        parent::init();
    }
}
