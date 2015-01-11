<?php
use yii\helpers\Html;
use frontend\modules\site\Module;

/* @var $this yii\web\View */
/* @var $model frontend\modules\site\models\Article */

$this->title = Module::t('Update Article') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('Update');
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>
