<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\site\models\Article */

$this->title = Yii::t('frontend-site', 'Update Article') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend-site', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend-site', 'Update');
?>
<div class="article-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="col-lg-8 well bs-component">

        <?php echo $this->render('_form', ['model' => $model]) ?>

    </div>

</div>
