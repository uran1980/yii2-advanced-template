<?php

/**
 * @var View $this
 */
use common\components\grid\GridView;
use common\components\grid\ActionColumn;
use common\components\grid\DataColumn;
use common\models\search\SourceMessageSearch;
use backend\assets\AppTranslateAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

$searchModel = SourceMessageSearch::getInstance();

$this->title = Yii::t('backend', 'Translations');
$this->params['breadcrumbs'][] = $this->title;

AppTranslateAsset::register($this);
?>

<div class="translations-index">
    <div class="row">
        <div class="col-lg-12">
            <span class="pull-left btn-group">
                <a class="btn btn-default <?php
                    $params = ArrayHelper::merge(Yii::$app->request->getQueryParams(), [
                        $searchModel->formName() => ['status' => SourceMessageSearch::STATUS_ALL],
                    ]);
                    $route = ArrayHelper::merge(['/backend/translations/index'], $params);
                    echo SourceMessageSearch::isActiveTranslation([
                        'url'       => $route,
                        'current'   => SourceMessageSearch::STATUS_ALL,
                    ]); ?>" href="<?php
                    echo Url::to($route); ?>"><?php
                    echo Yii::t('backend', 'All'); ?></a>
                <a class="btn btn-default <?php
                    $params = ArrayHelper::merge(Yii::$app->request->getQueryParams(), [
                        $searchModel->formName() => ['status' => SourceMessageSearch::STATUS_TRANSLATED],
                    ]);
                    $route = ArrayHelper::merge(['/backend/translations/index'], $params);
                    echo SourceMessageSearch::isActiveTranslation([
                        'url'       => $route,
                        'current'   => SourceMessageSearch::STATUS_TRANSLATED,
                    ]); ?>" href="<?php
                    echo Url::to($route); ?>"><?php
                    echo Yii::t('backend', 'Translated'); ?></a>
                <a class="btn btn-default <?php
                    $params = ArrayHelper::merge(Yii::$app->request->getQueryParams(), [
                        $searchModel->formName() => ['status' => SourceMessageSearch::STATUS_NOT_TRANSLATED],
                    ]);
                    $route = ArrayHelper::merge(['/backend/translations/index'], $params);
                    echo SourceMessageSearch::isActiveTranslation([
                        'url'       => $route,
                        'current'   => SourceMessageSearch::STATUS_NOT_TRANSLATED,
                    ]); ?>" href="<?php
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
            <a class="btn btn-warning btn-ajax" action="translation-clear-cache"
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
                    'width' => '30',
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
                'class' => ActionColumn::className(),
                'header' => '<i class="fa fa-copy"></i>',
                'footer' => '<i class="fa fa-copy"></i>',
                'template' => '{copy}',
                'headerOptions' => [
                    'width' => '30',
                ],
                'buttons' => [
                    'copy' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-arrow-right "></i>', '', [
                            'class'     => 'btn btn-xs btn-default translation-copy-from-source',
                            'title'     => Yii::t('common', 'Copy from source message'),
                        ]);
                    },
                ],
            ],
            [
                'label' => Yii::t('backend', 'Message Translations'),
                'filter' => false,
                'contentOptions' => [
                    'class' => 'translation-tabs tabs-mini',
                ],
                'value' => function ($model, $key, $index, $widget) {
                    return $this->render('_message-tabs', [
                        'model'     => $model,
                        'key'       => $key,
                        'index'     => $index,
                        'widget'    => $widget,
                    ]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'category',
                'headerOptions' => [
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
                        return Html::a('<i class="glyphicon glyphicon-download"></i> ' . Yii::t('common', 'Save'), $url, [
                            'class'                         => 'btn btn-xs btn-success btn-translation-save',
                            'action'                        => 'translation-save',
                            'title'                         => Yii::t('common', 'Save'),
                            'before-send-igrowl-title'      => Yii::t('backend', 'Request sent'),
                            'before-send-igrowl-message'    => Yii::t('backend', 'Please, wait...'),
                            'success-igrowl-title'          => Yii::t('backend', 'Server Response'),
                            'success-igrowl-message'        => Yii::t('backend', 'Message successfully saved.'),
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                            'class'                         => 'btn btn-xs btn-danger btn-ajax',
                            'action'                        => 'translation-delete',
                            'title'                         => Yii::t('common', 'Delete'),
                            'data-confirm'                  => Yii::t('common', 'Are you sure you want to delete this item?'),
                            'before-send-igrowl-title'      => Yii::t('backend', 'Request sent'),
                            'before-send-igrowl-message'    => Yii::t('backend', 'Please, wait...'),
                            'success-igrowl-title'          => Yii::t('backend', 'Server Response'),
                            'success-igrowl-message'        => Yii::t('backend', 'Message successfully deleted.'),
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
    ]); ?>
</div>
