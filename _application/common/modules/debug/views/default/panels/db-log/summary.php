<?php
/* @var $panel yii\debug\panels\DbLogPanel */
/* @var $totalCount int */
/* @var $errorCount int */
/* @var $warningCount int */
?>

<?php
$title  = 'Logged ' . $totalCount . ' messages';
$output = [];

if ($errorCount) {
    $output[] = "<span class=\"label label-danger\">$errorCount</span>";
    $title .= ", $errorCount errors";
}

if ($warningCount) {
    $output[] = "<span class=\"label label-warning\">$warningCount</span>";
    $title .= ", $warningCount warnings";
}
?>

<div class="yii-debug-toolbar-block">
    <a href="<?php echo $panel->getUrl(); ?>" title="<?php echo $title; ?>">DbLog
        <span class="label"><?php echo $totalCount; ?></span>
        <?php echo implode('&nbsp;', $output); ?>
    </a>
</div>
