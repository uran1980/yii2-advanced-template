<?php

namespace common\components\grid;

use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class DataColumn extends \yii\grid\DataColumn
{
    /**
     * @var array
     */
    public static $filterOptionsForChosenSelect = [
        'class'  => 'form-control chosen-select',
        'id'     => null,
        'prompt' => ' All ',
    ];

    public function init()
    {
        $this->headerOptions = ArrayHelper::merge([
            'class' => 'text-align-center',
        ], $this->headerOptions);
        $this->footerOptions = ArrayHelper::merge([
            'class' => 'text-align-center font-weight-bold th',
        ], $this->footerOptions);
    }

    /**
     * Used to render footer like header
     */
    protected function renderFooterCellContent()
    {
        return parent::renderHeaderCellContent();
    }

    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
            } else {
                return Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error;
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }
}
