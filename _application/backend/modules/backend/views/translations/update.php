<?php

/**
 * @var View $this
 * @var SourceMessage $model
 */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use common\modules\i18n\models\SourceMessage;

$this->title = Yii::t('backend', 'Update') . ': ' . $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-update">
    <div class="message-form">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo Yii::t('backend', 'Source message') ?></div>
            <div class="panel-body"><?php echo Html::encode($model->message) ?></div>
        </div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <?php foreach ($model->messages as $language => $message) : ?>
                <?php echo $form->field($model->messages[$language], '[' . $language . ']translation', ['options' => ['class' => 'form-group col-sm-6']])->textInput()->label($language) ?>
            <?php endforeach; ?>
        </div>
        <div class="form-group">
            <?php echo
            Html::submitButton(
                $model->getIsNewRecord() ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
                ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']
            ) ?>
        </div>
        <?php $form::end(); ?>
    </div>
</div>
