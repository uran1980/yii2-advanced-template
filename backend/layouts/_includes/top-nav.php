<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => Yii::t('app', Yii::$app->name),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top',
    ],
]);

// display Account and Users to admin+ roles
if (Yii::$app->user->can('admin')) {
    $menuItems[] = ['label' => Yii::t('app', 'Home'),  'url' => ['/backend/index/index']];
    $menuItems[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/backend/user/index']];
}

// display Login page to guests of the site
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/backend/index/login']];
}
// display Logout to all logged in users
else {
    $menuItems[] = [
        'label'       => Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
        'url'         => ['/backend/index/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
