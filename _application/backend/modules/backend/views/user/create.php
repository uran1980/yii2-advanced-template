<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $role common\rbac\models\Role */

$this->title = Yii::t('backend', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="col-lg-5 well bs-component">
        <?php echo $this->render('_form', [
            'user' => $user,
            'role' => $role,
        ]) ?>
    </div>
</div>

