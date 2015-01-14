<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use backend\modules\backend\Module;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo  Yii::$app->language; ?>">
    <head>
        <meta charset="<?php echo  Yii::$app->charset; ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo  Html::csrfMetaTags(); ?>
        <title><?php echo  Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="wrap">
            <?php include '_includes/top-nav.php'; ?>

            <div class="container">
            <?php echo  Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
            <?php echo  $content; ?>
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
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
