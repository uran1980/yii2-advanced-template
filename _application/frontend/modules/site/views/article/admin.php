<?php

use common\helpers\CssHelper;
use yii\helpers\Html;
use common\components\grid\GridView;
use common\components\grid\SerialColumn;
use common\components\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend-site', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-admin">
    <h1>
        <?php echo Html::encode($this->title); ?>
        <span class="pull-right"><?php
            echo Html::a('<i class="fa fa-plus"></i> ' . Yii::t('frontend-site', 'New Post'), ['create'], [
                'class' => 'btn btn-success',
            ]); ?></span>
    </h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => SerialColumn::className(),
            ],
            // author
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data->getAuthorName();
                },
            ],
            [
                'attribute' => 'title',
            ],
            // status
            [
                'attribute' => 'status',
                'filter' => $searchModel->statusList,
                'filterInputOptions' => [
                    'class'     => 'form-control chosen-select',
                    'id'        => null,
                    'prompt'    => ' All ',
                ],
                'value' => function ($data) {
                    return $data->getStatusName($data->status);
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class' => CssHelper::articleStatusCss($model->statusName)];
                }
            ],
            [
                'attribute' => 'category',
                'filter' => $searchModel->categoryList,
                'filterInputOptions' => [
                    'class'     => 'form-control chosen-select',
                    'id'        => null,
                    'prompt'    => ' All ',
                ],
                'value' => function ($data) {
                    return $data->getCategoryName($data->category);
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class' => CssHelper::articleCategoryCss($model->categoryName)];
                }
            ],
            [
                'class' => ActionColumn::className(),
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'class'     => 'btn btn-xs btn-default',
                            'title'     => Yii::t('common', 'Edit'),
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
