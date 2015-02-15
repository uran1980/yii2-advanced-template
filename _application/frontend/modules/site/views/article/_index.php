<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::t('frontend-site', 'Articles');
?>

    <h2>
        <a href=<?php echo Url::to(['article/view', 'id' => $model->id]) ?>><?php echo $model->title ?></a>
    </h2>

    <p class="time"><span class="glyphicon glyphicon-time"></span>
        Published on <?php echo date('F j, Y, g:i a', $model->created_at) ?></p>

    <br>

    <p><?php echo $model->summary ?></p>

    <a class="btn btn-primary" href=<?php echo Url::to(['article/view', 'id' => $model->id]) ?>>
        Read More <span class="glyphicon glyphicon-chevron-right"></span>
    </a>

    <hr class="article-devider">
