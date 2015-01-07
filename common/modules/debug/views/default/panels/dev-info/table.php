<?php
/* @var $caption string */
/* @var $values array */

use yii\helpers\Html;
use yii\helpers\VarDumper;
?>
<h3><?php echo $caption; ?></h3>

<?php echo $description; ?>

<?php if (empty($values)): ?>
    <p>Empty.</p>
<?php else:	?>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-striped table-hover request-table" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th class="text-align-center" width="100">Name</th>
                    <th class="text-align-center">Value</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($values as $name => $value): ?>
                <tr>
                    <th><?php echo Html::encode($name); ?></th>
                    <td class="font-size-11px"><?php
                        echo htmlspecialchars(VarDumper::dumpAsString($value), ENT_QUOTES|ENT_SUBSTITUTE, \Yii::$app->charset, true); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
