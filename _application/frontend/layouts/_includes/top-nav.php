<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\components\widgets\LanguageSwitcher;
use frontend\modules\site\Module;
use common\rbac\AccessControl;
use Yii;

NavBar::begin([
    'brandLabel' => Module::t(Yii::$app->name),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top',
    ],
]);

// everyone can see Home page
$menuItems[] = ['label' => Module::t('Home'), 'url' => ['/site/index/index']];

// we do not need to display Article/index, About and Contact pages to editor+ roles
if (!Yii::$app->user->can(AccessControl::ROLE_EDITOR)) {
    $menuItems[] = ['label' => Module::t('Articles'),   'url' => ['/site/article/index']];
    $menuItems[] = ['label' => Module::t('About'),      'url' => ['/site/index/about']];
    $menuItems[] = ['label' => Module::t('Contact'),    'url' => ['/site/index/contact']];
}

// display Article admin page to editor+ roles
if (Yii::$app->user->can(AccessControl::ROLE_EDITOR)) {
    $menuItems[] = ['label' => Module::t('Articles'), 'url' => ['/site/article/admin']];
}

// display Signup and Login pages to guests of the site
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Module::t('Signup'), 'url' => ['/profile/index/signup']];
    $menuItems[] = ['label' => Module::t('Login'),  'url' => ['/profile/index/login']];
}
// display Logout to all logged in users
else {
    $menuItems[] = [
        'label'       => Module::t('Logout'). ' (' . Yii::$app->user->identity->username . ')',
        'url'         => ['/logout'],
        'linkOptions' => ['data-method' => 'post'],
    ];
}
if ( Yii::$app->has('localeUrls') ) {
    echo '<div class="lang-switcher pull-right">' . LanguageSwitcher::widget() . '</div>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => $menuItems,
]);
NavBar::end();
