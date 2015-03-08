<?php

use yii\helpers\Html;

uran1980\yii\widgets\pace\Pace::widget();
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
        <?php echo uran1980\yii\widgets\scrollToTop\ScrollToTop::widget(); ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
