<?php

use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\site\models\forms\SignupForm */

$this->title = Yii::t('frontend-profile', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index-signup row">
    <div class="col-lg-6 col-lg-push-3">
        <h1><?php echo Html::encode($this->title) ?></h1>

        <div class="well bs-component">
            <p><?php echo Yii::t('frontend-profile', 'Please fill out the following fields to signup:') ?></p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?php echo $form->field($model, 'username') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php echo $form->field($model, 'password')->widget(PasswordInput::classname(), []) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend-profile', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <?php if ($model->scenario === 'RegistrationNeedsActivation'): ?>
            <div style="color: #666; margin: 1em 0;">
                <i>*<?php echo Yii::t('frontend-profile', 'We will send you an email with profile activation link.') ?></i>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>