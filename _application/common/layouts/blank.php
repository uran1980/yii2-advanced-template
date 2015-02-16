<?php

use common\components\widgets\Alert;

?>
<?php $this->beginContent('@common/layouts/base.php'); ?>
<div class="container">
    <?php echo Alert::widget(); ?>
    <?php echo $content; ?>
</div>
<?php $this->endContent();
