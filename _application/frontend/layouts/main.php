<?php

use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\modules\site\Module;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginContent('@common/layouts/base.php'); ?>
<div class="wrap">
    <?php include '_includes/top-nav.php'; ?>

    <div class="container">
    <?php echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <?php echo Alert::widget(); ?>
    <?php echo $content; ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
    <p class="pull-left">&copy; <?php echo Module::t(Yii::$app->name); ?> <?php echo date('Y'); ?></p>
    <p class="pull-right"><?php echo Yii::powered(); ?></p>
    </div>
</footer>

<a href="#wrapper" class="scroll-to-top-link" style="display: none;"><?php
    echo Module::t('Scroll to top'); ?></a>
<?php $this->endContent();
