<?php

use common\helpers\CssHelper;
use common\models\search\UserSearch;
use common\components\grid\SerialColumn;
use common\components\grid\ActionColumn;
use common\components\grid\DataColumn;
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
                'filterInputOptions' => DataColumn::$filterOptionsForChosenSelect,
                'value' => function ($data) {
                    return '<span class="' . CssHelper::statusCssLabel($data->statusName) . '">' . $data->statusName . '</span>';
                },
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
            ],
            // role
            [
                'attribute' => 'item_name',
                'filter' => $searchModel->rolesList,
                'filterInputOptions' => DataColumn::$filterOptionsForChosenSelect,
                'value' => function ($data) {
                    return $data->roleName;
                },
                'contentOptions' => function($model, $key, $index, $column) {
                    return [
                        'class' => 'text-align-center ' . CssHelper::roleCss($model->roleName),
                    ];
                }
            ],
            // actions buttons
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, [
                            'title' => Yii::t('backend', 'View user'),
                            'class' => 'glyphicon glyphicon-eye-open',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, [
                            'title' => Yii::t('backend', 'Manage user'),
                            'class' => 'glyphicon glyphicon-user',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url, [
                            'title' => Yii::t('backend', 'Delete user'),
                            'class' => 'glyphicon glyphicon-trash text-danger margin-left-10px',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this user?'),
                                'method'  => 'post',
                            ],
                        ]);
                    },
                ],
            ], // ActionColumn
        ], // columns
    ]); ?>
</div>
