<?php

/**
 * @var View $this
 */
use common\components\grid\GridView;
use common\components\grid\SerialColumn;
use common\components\grid\ActionColumn;
use common\components\grid\DataColumn;
use common\models\search\SourceMessageSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
//use yii\widgets\Pjax;
use yii\helpers\Url;

$searchModel = SourceMessageSearch::getInstance();

$this->title = Yii::t('backend', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="translations-index">
    <div class="row">
        <div class="col-lg-12">
            <span class="pull-left btn-group">
                <a class="btn btn-default <?php
                    $route = ['/backend/translations/index'];
                    echo SourceMessageSearch::isActiveTranslation(['url' => $route]); ?>" href="<?php
                    echo Url::to($route); ?>"><?php
                    echo Yii::t('backend', 'All'); ?></a>
                <a class="btn btn-default <?php
                    $route = [
                        '/backend/translations/index',
                        $searchModel->formName() . '[status]' => SourceMessageSearch::STATUS_TRANSLATED,
                    ];
                    echo SourceMessageSearch::isActiveTranslation(['url' => $route]); ?>" href="<?php
                    echo Url::to($route); ?>"><?php
                    echo Yii::t('backend', 'Translated'); ?></a>
                <a class="btn btn-default <?php
                    $route = [
                        '/backend/translations/index',
                        $searchModel->formName() . '[status]' => SourceMessageSearch::STATUS_NOT_TRANSLATED,
                    ];
                    echo SourceMessageSearch::isActiveTranslation(['url' => $route]); ?>" href="<?php
                    echo Url::to($route); ?>"><?php
                    echo Yii::t('backend', 'Not Translated'); ?></a>
            </span>
        </div>
    </div>
    <h2>
        <?php echo Html::encode($this->title); ?>
        <span class="pull-right btn-group">
            <a class="btn btn-success" href="<?php
                echo Url::to(['/backend/translations/rescan']); ?>"><i class="fa fa-refresh"></i> <?php
                echo Yii::t('backend', 'Rescan'); ?></a>
            <a class="btn btn-warning btn-ajax"
               before-send-igrowl-title="<?php echo Yii::t('backend', 'Request sent'); ?>"
               before-send-igrowl-message="<?php echo Yii::t('backend', 'Please, wait...'); ?>"
               success-igrowl-title="<?php echo Yii::t('backend', 'Server Response'); ?>"
               success-igrowl-message="<?php echo Yii::t('backend', 'Cache successfully cleared.'); ?>"
               href="<?php
               echo Url::to(['/backend/translations/clear-cache']); ?>"><i class="fa fa-recycle"></i> <?php
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
                'filterInputOptions' => DataColumn::$filterOptionsForChosenSelect,
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
                'filter' => Html::dropDownList(
                    $searchModel->formName() . '[status]',
                    $searchModel->status,
                    $searchModel->getStatus(),
                    DataColumn::$filterOptionsForChosenSelect
                ),
                'visible' => false,
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{save} {fullscreen} {delete}',
                'buttons' => [
                    'save' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-download"></span> ' . Yii::t('common', 'Save'), $url, [
                            'class'     => 'btn btn-xs btn-success',
                            'title'     => Yii::t('common', 'Save'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'fullscreen' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-fullscreen"></span>', '', [
                            'class'     => 'btn btn-xs btn-default',
                            'title'     => Yii::t('common', 'Expand'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'class'         => 'btn btn-xs btn-danger margin-left-10px',
                            'title'         => Yii::t('common', 'Delete'),
                            'data-confirm'  => Yii::t('common', 'Are you sure you want to delete this item?'),
                            'data-method'   => 'post',
                            'data-pjax'     => '0',
                        ]);
                    },
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
