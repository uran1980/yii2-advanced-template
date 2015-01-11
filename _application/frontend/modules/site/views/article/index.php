<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use frontend\modules\site\Module;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t(Yii::$app->name) .' '. Module::t('news');
$this->params['breadcrumbs'][] = Module::t('Articles');
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="small"> - <?= Module::t('The best news available') ?></span>
    </h1>

    <hr class="top">

    <?= ListView::widget([
        'summary'       => false,
        'dataProvider'  => $dataProvider,
        'emptyText'     => Module::t('We haven\'t created any articles yet.'),
        'itemOptions'   => ['class' => 'item'],
        'itemView'      => function ($model, $key, $index, $widget) {
            return $this->render('_index', ['model' => $model]);
        },
    ]) ?>

</div>
