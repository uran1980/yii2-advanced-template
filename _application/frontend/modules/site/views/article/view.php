<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\rbac\AccessControl;

/* @var $this yii\web\View */
/* @var $model frontend\modules\site\models\Article */

$this->title = $model->title;

$this->params['breadcrumbs'][]  = ['label' => Yii::t('frontend-site', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][]  = $this->title;
?>
<div class="article-view">
    <h1><?php echo Html::encode($this->title) ?>
        <div class="pull-right">
        <?php if (Yii::$app->user->can(AccessControl::PERMISSION_ADMIN_ARTICLE)): ?>
            <?php echo Html::a(Yii::t('frontend-site', 'Back'), ['admin'], ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(AccessControl::PERMISSION_UPDATE_ARTICLE, ['model' => $model])): ?>
            <?php echo Html::a(Yii::t('frontend-site', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(AccessControl::PERMISSION_DELETE_ARTICLE)): ?>
            <?php echo Html::a(Yii::t('frontend-site', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'toggle'  => 'confirmation',
                    'confirm' => Yii::t('frontend-site', 'Are you sure?'),
                    'method'  => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        </div>
    </h1>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
             [
                 'label' => Yii::t('frontend-site', 'Author'),
                 'value' => $model->authorName,
             ],
            'title',
            'summary:ntext',
            'content:html',
             [
                 'label' => Yii::t('frontend-site', 'Status'),
                 'value' => $model->statusName,
             ],
            [
                'label' => Yii::t('frontend-site', 'Category'),
                'value' => $model->categoryName,
            ],
            'created_at:dateTime',
            'updated_at:dateTime',
        ],
    ]) ?>
</div>
