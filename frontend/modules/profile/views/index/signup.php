<?php
use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\modules\profile\Module;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\site\models\SignupForm */

$this->title = Module::t('Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup row">
    <div class="col-lg-6 col-lg-push-3">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="well bs-component">
            <p><?= Module::t('Please fill out the following fields to signup:') ?></p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->widget(PasswordInput::classname(), []) ?>
                <div class="form-group">
                    <?= Html::submitButton(Module::t('Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <?php if ($model->scenario === 'RegistrationNeedsActivation'): ?>
            <div style="color: #666; margin: 1em 0;">
                <i>*<?= Module::t('We will send you an email with profile activation link.') ?></i>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>