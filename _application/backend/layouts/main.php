<?php

use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use common\components\widgets\Alert;

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
<?php $this->endContent();
