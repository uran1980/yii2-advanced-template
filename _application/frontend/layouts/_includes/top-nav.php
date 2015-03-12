<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\components\widgets\LanguageSwitcher;
use common\rbac\AccessControl;

?>
<?php if ( isset($this->blocks['top-nav']) ) { ?>
    <?php echo $this->blocks['top-nav']; ?>
<?php } else {
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    // everyone can see Home page
    $menuItems[] = ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index/index']];

    if ( Yii::$app->user->can(AccessControl::ROLE_USER) ) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Profile'), 'url' => ['/profile/index/index']];
    }

    // we do not need to display Article/index, About and Contact pages to editor+ roles
    if (!Yii::$app->user->can(AccessControl::ROLE_EDITOR)) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Posts'),   'url' => ['/site/article/index']];
        $menuItems[] = ['label' => Yii::t('frontend', 'About'),   'url' => ['/site/index/about']];
        $menuItems[] = ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/index/contact']];
    }

    // display Article admin page to editor+ roles
    if (Yii::$app->user->can(AccessControl::ROLE_EDITOR)) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Posts'), 'url' => ['/site/article/admin']];
    }

    // for admin show link to backend
    // @see https://github.com/yiisoft/yii2/issues/1578
    if ( Yii::$app->user->can(AccessControl::ROLE_ADMIN) ) {
        $menuItems[] = [
            'label' => Yii::t('frontend', 'Backend'),
            'url'   => Yii::$app->urlManagerBackend->baseUrl,
    //        'linkOptions' => [
    //            'target' => '_blank',
    //        ],
        ];
    }

    // display Signup and Login pages to guests of the site
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/profile/index/signup']];
        $menuItems[] = ['label' => Yii::t('frontend', 'Login'),  'url' => ['/profile/index/login']];
    }
    // display Logout to all logged in users
    else {
        $menuItems[] = [
            'label'       => Yii::t('frontend', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
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
}
