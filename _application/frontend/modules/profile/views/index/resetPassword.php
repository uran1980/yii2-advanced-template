<?php

use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\modules\site\models\forms\ResetPasswordForm */

$this->title = Yii::t('frontend-profile', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index-reset-password">

    <div class="col-lg-5 well bs-component">

        <h1><?php echo Html::encode($this->title) ?></h1>

        <p><?php echo Yii::t('frontend-profile', 'Please choose your new password:') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?php echo $form->field($model, 'password')->widget(PasswordInput::classname(), []) ?>

            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('frontend-profile', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
