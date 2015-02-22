<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="backend-index-error">
    <h1><?php echo Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?php echo nl2br(Html::encode($message)) ?>
    </div>
    <p>
        <?php echo Yii::t('backend', 'The above error occurred while the Web server was processing your request.') ?>
    </p>
    <p>
        <?php echo Yii::t('backend', 'Please contact us if you think this is a server error. Thank you.') ?>
    </p>

</div>
