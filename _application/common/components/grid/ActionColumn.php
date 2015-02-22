<?php

namespace common\components\grid;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
            'class' => 'text-align-center nowrap',
        ]);

        parent::init();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'class'     => 'btn btn-xs btn-default',
                    'title'     => Yii::t('common', 'View'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'class'     => 'btn btn-xs btn-default',
                    'title'     => Yii::t('common', 'Update'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if ( !isset($this->buttons['save']) ) {
            $this->buttons['save'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-download"></span> ' . Yii::t('common', 'Save'), $url, [
                    'class'     => 'btn btn-xs btn-success',
                    'title'     => Yii::t('common', 'Save'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'class'         => 'btn btn-xs btn-danger margin-left-10px',
                    'title'         => Yii::t('common', 'Delete'),
                    'data-confirm'  => Yii::t('common', 'Are you sure you want to delete this item?'),
                    'data-method'   => 'post',
                    'data-pjax'     => '0',
                ]);
            };
        }

    }
}
