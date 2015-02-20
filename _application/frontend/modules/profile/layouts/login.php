<?php

/* @var $this yii\web\View */
$this->beginContent('@frontend/layouts/main.php'); ?>

<div class="row">
    <div class="col-sm-push-3 col-sm-6">
        <?php echo $content; ?>
    </div>
</div>

<?php $this->endContent();