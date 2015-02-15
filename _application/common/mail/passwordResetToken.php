<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['profile/index/reset-password', 
    'token' => $user->password_reset_token]);
?>

Hello <?php echo Html::encode($user->username) ?>,

Follow this link below to reset your password:

<?php echo Html::a('Please, click here to reset your password.', $resetLink) ?>
