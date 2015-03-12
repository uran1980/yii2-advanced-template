<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-index-error">
    <div class="jumbotron margin-bottom-60px">
        <h1 class="text-danger"><?php echo Html::encode($this->title); ?></h1>
        <h2><?php echo nl2br(Html::encode($message)); ?></h2>
        <p><?php
            echo Yii::t('frontend-site', 'The above error occurred while the Web server was processing your request.') . '<br />';
            echo Yii::t('frontend-site', 'Please {contact us} if you think this is a server error. Thank you.', [
                'contact us' => Html::a(Yii::t('common', 'contact us'), ['/contact']),
            ]); ?></p>
        <p>
            <a class="btn btn-primary" href="<?php
                echo Yii::$app->request->referrer; ?>"><i class="fa fa-arrow-left"></i> <?php
                echo Yii::t('common', 'Return'); ?></a>
            <a class="btn btn-primary" href="<?php echo Yii::$app->homeUrl; ?>"><i class="fa fa-home"></i> <?php
                echo Yii::t('common', 'Home'); ?></a>
        </p>
    </div>
</div>
