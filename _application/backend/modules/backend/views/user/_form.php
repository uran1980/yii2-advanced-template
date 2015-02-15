<?php

use common\rbac\models\AuthItem;
use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $role common\rbac\models\Role; */
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>
        <?php echo $form->field($user, 'username') ?>
        <?php echo $form->field($user, 'email') ?>
        <?php if ($user->scenario === 'create'): ?>
            <?php echo $form->field($user, 'password')->widget(PasswordInput::classname(), []) ?>
        <?php else: ?>
            <?php echo $form->field($user, 'password')->widget(PasswordInput::classname(), [])
                     ->passwordInput(['placeholder' => Yii::t('backend', 'New pwd ( if you want to change it )')])
            ?>
        <?php endif ?>
    <div class="row">
        <div class="col-lg-6">
            <?php echo $form->field($user, 'status')->dropDownList($user->statusList) ?>
            <?php foreach (AuthItem::getRoles() as $item_name): ?>
                <?php $roles[$item_name->name] = $item_name->name ?>
            <?php endforeach ?>
            <?php echo $form->field($role, 'item_name')->dropDownList($roles) ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton($user->isNewRecord ? Yii::t('backend', 'Create')
            : Yii::t('backend', 'Update'), ['class' => $user->isNewRecord
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php echo Html::a(Yii::t('backend', 'Cancel'), ['user/index'], ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
