<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use backend\modules\backend\Module;
use common\rbac\AccessControl;
use common\components\widgets\LanguageSwitcher;

NavBar::begin([
    'brandLabel' => Module::t('Backend Dashboard'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top',
    ],
]);

$menuItems[] = [
    'label' => Module::t('Site'),
    'url' => Yii::$app->urlManagerFrontend->baseUrl,
//    'linkOptions' => [
//        'target' => '_blank',
//    ],
];

// display Account and Users to admin+ roles
if (Yii::$app->user->can(AccessControl::ROLE_ADMIN)) {
//    $menuItems[] = ['label' => Module::t('Home'),  'url' => ['/backend/index/index']];
    $menuItems[] = ['label' => Module::t('Users'), 'url' => ['/backend/user/index']];
}
if ( Yii::$app->user->can(AccessControl::ROLE_TRANSLATOR) ) {
    $menuItems[] = ['label' => Module::t('Translations'), 'url' => ['/translations']];
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
if ( \Yii::$app->has('localeUrls') ) {
    echo '<div class="lang-switcher pull-right">' . LanguageSwitcher::widget() . '</div>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => $menuItems,
]);
NavBar::end();
