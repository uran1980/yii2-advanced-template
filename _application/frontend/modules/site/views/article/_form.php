<?php

//use mihaildev\ckeditor\CKEditor;
use uran1980\yii\widgets\markdown\MarkdownEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\site\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]); ?>
    <?php echo $form->field($model, 'summary')->textarea(['rows' => 6]); ?>
    <?php
//        echo $form->field($model, 'content')->widget(CKEditor::className(), ['editorOptions' => [
//            'preset' => 'full',
//            'inline' => false,
//        ]]); ?>
    <?php
        echo $form->field($model, 'content')->widget(MarkdownEditor::className(), [
            'options' => ['data-provider' => 'markdown'],
        ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php echo $form->field($model, 'status')->dropDownList($model->statusList); ?>
            <?php echo $form->field($model, 'category')->dropDownList($model->categoryList); ?>
        </div>
    </div>

    <div class="form-group"><?php
        echo Html::submitButton($model->isNewRecord
            ? Yii::t('frontend-site', 'Create')
            : Yii::t('frontend-site', 'Update'), [
                'class' => ($model->isNewRecord ? 'btn btn-success margin-right-5px' : 'btn btn-primary margin-right-5px'),
            ]);
        echo Html::a(Yii::t('frontend-site', 'Cancel'), ['article/index'], [
            'class' => 'btn btn-default',
        ]); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
