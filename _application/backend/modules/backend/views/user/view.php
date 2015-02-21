<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?php echo Html::encode($this->title) ?>

    <div class="pull-right">
        <?php echo Html::a(Yii::t('backend', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this user?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    </h1>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            //'password_hash',
            [
                'attribute' => 'status',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute' => 'item_name',
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
