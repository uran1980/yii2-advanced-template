<?php

/**
 * @var View $this
 */
use common\components\grid\GridView;
use common\components\grid\SerialColumn;
use common\components\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
//use yii\widgets\Pjax;
use common\models\search\SourceMessageSearch;
use yii\helpers\Url;

$searchModel = SourceMessageSearch::getInstance();

$this->title = Yii::t('backend', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-index">
    <h2>
        <?php echo Html::encode($this->title); ?>
        <span class="pull-right btn-group">
            <a class="btn btn-success" href="<?php
                echo Url::toRoute('/translations/rescan'); ?>"><i class="fa fa-refresh"></i> <?php
                echo Yii::t('backend', 'Rescan'); ?></a>
            <a class="btn btn-warning btn-ajax"
               before-send-igrowl-title="<?php echo Yii::t('backend', 'Request sent'); ?>"
               before-send-igrowl-message="<?php echo Yii::t('backend', 'Please, wait...'); ?>"
               success-igrowl-title="<?php echo Yii::t('backend', 'Server Response'); ?>"
               success-igrowl-message="<?php echo Yii::t('backend', 'Cache successfully cleared.'); ?>"
               href="<?php
               echo Url::toRoute('/translations/clear-cache'); ?>"><i class="fa fa-recycle"></i> <?php
               echo Yii::t('backend', 'Clear Cache'); ?></a>
        </span>
    </h2>
    <?php
//    Pjax::begin();
    echo GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $searchModel->search(Yii::$app->getRequest()->get()),
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'class' => 'text-align-center',
                    'width' => '30',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model, $key, $index, $dataColumn) {
                    return $model->id;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'message',
                'label' => Yii::t('frontend-site', 'Sourse Messages'),
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return Html::a($model->message, ['update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                },
            ],
            [
                'label' => '',
                'headerOptions' => [
                    'class' => 'text-align-center',
                    'width' => '30',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'filter' => false,
                'value' => function ($model, $key, $index, $widget) {
                    return ' => ';
                },
            ],
            [
                'label' => Yii::t('backend', 'Message Translations'),
                'filter' => false,
                'value' => function ($model, $key, $index, $widget) {
                    return 'TODO';
                },
            ],
            [
                'attribute' => 'category',
                'headerOptions' => [
                    'class' => 'text-align-center',
                    'width' => '150',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model, $key, $index, $dataColumn) {
                    return $model->category;
                },
                'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category'),
                'filterInputOptions' => [
                    'class'     => 'form-control chosen-select',
                    'id'        => null,
                    'prompt'    => ' All ',
                ],
            ],
            [
                'attribute' => 'status',
                'headerOptions' => [
                    'class' => 'text-align-center',
                    'width' => '150',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model, $key, $index, $widget) {
                    return '';
                },
                'filter' => Html::dropDownList($searchModel->formName() . '[status]', $searchModel->status, $searchModel->getStatus(), [
                    'class'  => 'form-control chosen-select',
                    'prompt' => ' All ',
                ]),
            ],
            [
                'class' => ActionColumn::className(),
                'headerOptions' => [
                    'class' => 'text-align-center',
                    'width' => '75',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
            ],
            [
                'attribute' => 'location',
                'value' => function ($model, $key, $index, $dataColumn) {
                    return $model->location;
                },
                'enableSorting' => false,
                'visible' => false,
            ],
        ],
    ]);
//    Pjax::end();
    ?>
</div>
