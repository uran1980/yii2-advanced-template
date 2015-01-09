<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\modules\site\Module;

/* @var $this yii\web\View */
/* @var $model frontend\modules\site\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?>

    <div class="pull-right">

    <?php if (Yii::$app->user->can('adminArticle')): ?>

        <?= Html::a(Module::t('Back'), ['admin'], ['class' => 'btn btn-warning']) ?>

    <?php endif ?>

    <?php if (Yii::$app->user->can('updateArticle', ['model' => $model])): ?>

        <?= Html::a(Module::t('Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?php endif ?>

    <?php if (Yii::$app->user->can('deleteArticle')): ?>

        <?= Html::a(Module::t('Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('Are you sure you want to delete this article?'),
                'method' => 'post',
            ],
        ]) ?>

    <?php endif ?>

    </div>

    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            // [
            //     'label' => Module::t('Author'),
            //     'value' => $model->authorName,
            // ],
            'title',
            'summary:ntext',
            'content:html',
            // [
            //     'label' => Module::t('Status'),
            //     'value' => $model->statusName,
            // ],
            [
                'label' => Module::t('Category'),
                'value' => $model->categoryName,
            ],
            'created_at:dateTime',
            //'updated_at:dateTime',
        ],
    ]) ?>

</div>
