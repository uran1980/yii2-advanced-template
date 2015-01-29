<?php

use yii\helpers\Html;

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php echo  Html::csrfMetaTags(); ?>
        <title><?php echo Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <?php echo $content; ?>
        <?php include '_includes/footer.php'; ?>
        <a href="#wrapper" class="scroll-to-top-link" style="display: none;"><?php
            echo Module::t('Scroll to top'); ?></a>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
