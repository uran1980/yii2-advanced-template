<?php
use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\modules\profile\Module;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\site\models\ResetPasswordForm */

$this->title = Module::t('Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">

    <div class="col-lg-5 well bs-component">

        <h1><?= Html::encode($this->title) ?></h1>

        <p><?= Module::t('Please choose your new password:') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->widget(PasswordInput::classname(), []) ?>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Save'), ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
