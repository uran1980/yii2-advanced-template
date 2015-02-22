<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' '. Yii::t('frontend-site', 'news');
$this->params['breadcrumbs'][] = Yii::t('frontend-site', 'Articles');
?>
<div class="article-index">

    <h1><?php echo Html::encode($this->title) ?>
        <span class="small"> - <?php echo Yii::t('frontend-site', 'The best news available') ?></span>
    </h1>

    <hr class="top">

    <?php echo ListView::widget([
        'summary'       => false,
        'dataProvider'  => $dataProvider,
        'emptyText'     => Yii::t('frontend-site', "We haven't created any articles yet."),
        'itemOptions'   => ['class' => 'item'],
        'itemView'      => function ($model, $key, $index, $widget) {
            return $this->render('_index', ['model' => $model]);
        },
    ]) ?>

</div>
