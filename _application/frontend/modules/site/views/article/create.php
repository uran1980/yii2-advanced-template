<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = Yii::t('frontend-site', 'Create Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend-site', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="col-lg-8 well bs-component">

        <?php echo $this->render('_form', ['model' => $model]) ?>

    </div>

</div>
