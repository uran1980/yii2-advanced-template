<?php

use common\helpers\CssHelper;
use yii\helpers\Html;
use common\components\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend-site', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-admin">
    <h1>
        <?php echo Html::encode($this->title) ?>
        <span class="pull-right">
            <?php echo Html::a(Yii::t('frontend-site', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
        </span>
    </h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            [
                'class' => \yii\grid\SerialColumn::className(),
                'header' => '#',
                'footer' => '#',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
            ],

            //'id',
            // author
            [
                'attribute' => 'user_id',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'value' => function ($data) {
                    return $data->getAuthorName();
                },
            ],
            [
                'attribute' => 'title',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
            ],
            // status
            [
                'attribute' => 'status',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
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
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
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
                'class' => \yii\grid\ActionColumn::className(),
                'header' => Yii::t('frontend-site', 'Menu'),
                'footer' => Yii::t('frontend-site', 'Menu'),
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
            ],
        ],
    ]); ?>

</div>
