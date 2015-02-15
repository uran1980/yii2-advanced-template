<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\site\models\PasswordResetRequestForm */

$this->title = Yii::t('frontend-profile', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index-request-password-reset">

    <div class="col-lg-5 well bs-component">

        <h1><?php echo Html::encode($this->title) ?></h1>

        <p><?php echo Yii::t('frontend-profile', 'A link to reset password will be sent to your email.') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?php echo $form->field($model, 'email')->textInput(['placeholder' => Yii::t('frontend-profile', 'Please fill out your email.')]) ?>

            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('frontend-profile', 'Send'), ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
