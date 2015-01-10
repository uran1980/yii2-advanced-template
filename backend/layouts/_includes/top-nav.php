<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use backend\modules\backend\Module;
use common\rbac\AccessControl;

NavBar::begin([
    'brandLabel' => Module::t(Yii::$app->name),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top',
    ],
]);

// display Account and Users to admin+ roles
if (Yii::$app->user->can(AccessControl::ROLE_ADMIN)) {
    $menuItems[] = ['label' => Module::t('Home'),  'url' => ['/backend/index/index']];
    $menuItems[] = ['label' => Module::t('Users'), 'url' => ['/backend/user/index']];
}

// display Login page to guests of the site
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Module::t('Login'), 'url' => ['/backend/index/login']];
}
// display Logout to all logged in users
else {
    $menuItems[] = [
        'label'       => Module::t('Logout'). ' (' . Yii::$app->user->identity->username . ')',
        'url'         => ['/backend/index/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
