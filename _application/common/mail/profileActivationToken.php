<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-profile',
    'token' => $user->profile_activation_token]);
?>

Hello <?= Html::encode($user->username) ?>,

Follow this link to activate your profile:

<?= Html::a('Please, click here to activate your profile.', $resetLink) ?>
