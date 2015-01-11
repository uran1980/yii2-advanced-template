<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\backend\Module;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Module::t('Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?>

    <div class="pull-right">
        <?= Html::a(Module::t('Back'), ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Module::t('Update'), ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary']) ?>
        <?= Html::a(Module::t('Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('Are you sure you want to delete this user?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            //'password_hash',
            [
                'attribute'=>'status',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute'=>'item_name',
                'value' => $model->getRoleName(),
            ],
            //'auth_key',
            //'password_reset_token',
            //'profile_activation_token',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
