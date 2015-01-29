<?php if ( isset($this->blocks['footer']) ) { ?>
    <?php echo $this->blocks['footer']; ?>
<?php } else { ?>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?php echo Yii::t('common', Yii::$app->name); ?> <?php echo date('Y'); ?></p>
        <p class="pull-right"><?php echo Yii::powered(); ?></p>
    </div>
</footer>
<?php }
