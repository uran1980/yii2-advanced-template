<?php

use common\helpers\CssHelper;
use common\models\search\UserSearch;
use common\components\grid\SerialColumn;
use common\components\grid\ActionColumn;
use common\components\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */

/** @var UserSearch $searchModel */
$searchModel = UserSearch::getInstance();

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backend-user-index">
    <h1><?php echo Html::encode($this->title); ?>
        <span class="pull-right">
            <?php echo Html::a(Yii::t('backend', 'Create User'), ['create'], ['class' => 'btn btn-success']); ?>
        </span>
    </h1>

    <?php echo GridView::widget([
        'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            [
                'class' => SerialColumn::className(),
            ],
            // username
            [
                'attribute' => 'username',
            ],
            // email
            [
                'attribute' => 'email',
            ],
            // status
            [
                'attribute' => 'status',
                'filter' => $searchModel->statusList,
                'value' => function ($data) {
                    return $data->statusName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::statusCss($model->statusName)];
                }
            ],
            // role
            [
                'attribute' => 'item_name',
                'filter' => $searchModel->rolesList,
                'value' => function ($data) {
                    return $data->roleName;
                },
                'contentOptions' => function($model, $key, $index, $column) {
                    return ['class' => CssHelper::roleCss($model->roleName)];
                }
            ],
            // actions buttons
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title' => 'View user',
                            'class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title' => 'Manage user',
                            'class' => 'glyphicon glyphicon-user']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url,
                        ['title' => 'Delete user',
                            'class' => 'glyphicon glyphicon-trash',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this user?'),
                                'method' => 'post']
                        ]);
                    },
                ],
            ], // ActionColumn
        ], // columns
    ]); ?>
</div>
