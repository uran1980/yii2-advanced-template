<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\modules\profile\Module;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\site\models\PasswordResetRequestForm */

$this->title = Module::t('Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index-request-password-reset">

    <div class="col-lg-5 well bs-component">

        <h1><?= Html::encode($this->title) ?></h1>

        <p><?= Module::t('A link to reset password will be sent to your email.') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => Module::t('Please fill out your email.')]) ?>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Send'), ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
