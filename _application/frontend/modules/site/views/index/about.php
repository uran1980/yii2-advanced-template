<?php
use yii\helpers\Html;
use frontend\modules\site\Module;

/* @var $this yii\web\View */

$this->title = Module::t('About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
