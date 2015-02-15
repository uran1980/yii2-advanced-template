<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('backend', 'Login');
?>
<div class="backend-login row">
    <div class="col-lg-5 col-lg-push-3">
        <h1 class="login"><?php echo Html::encode($this->title); ?></h1>

        <div class="well bs-component">
            <p><?php echo Yii::t('backend', 'Please fill out the following fields to login:'); ?></p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php //-- use email or username field depending on model scenario --// ?>
                <?php if ($model->scenario === 'LoginWithEmail'): ?>
                    <?php echo $form->field($model, 'email'); ?>
                <?php else: ?>
                    <?php echo $form->field($model, 'username'); ?>
                <?php endif ?>

                <?php echo $form->field($model, 'password')->passwordInput(); ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>

                <div class="form-group"><?php
                    echo Html::submitButton(Yii::t('backend', 'Login'), [
                        'class' => 'btn btn-primary',
                        'name'  => 'login-button',
                    ]); ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
