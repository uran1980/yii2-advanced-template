<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\forms\LoginForm */

$this->title = Yii::t('frontend-profile', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="profile-index-login row">
    <div class="col-md-5 col-md-push-3">
        <h1><?php echo Html::encode($this->title); ?></h1>

        <div class="well bs-component">
            <p><?php echo Yii::t('frontend-profile', 'Please fill out the following fields to login:'); ?></p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php //-- use email or username field depending on model scenario --// ?>
                <?php if ($model->scenario === 'LoginWithEmail'): ?>
                    <?php echo $form->field($model, 'email'); ?>
                <?php else: ?>
                    <?php echo $form->field($model, 'username'); ?>
                <?php endif ?>

                <?php echo $form->field($model, 'password')->passwordInput(); ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>

                <div style="color: #999; margin: 1em 0;">
                    <?php echo Yii::t('frontend-profile', 'If you forgot your password you can'); ?>
                    <?php echo Html::a(Yii::t('frontend-profile', 'reset it'), ['/profile/index/request-password-reset']); ?>.
                </div>

                <div class="form-group"><?php
                    echo Html::submitButton(Yii::t('frontend-profile', 'Login'), [
                        'class' => 'btn btn-primary',
                        'name' => 'login-button',
                    ]); ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
