<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\rbac\AccessControl;
use common\components\widgets\LanguageSwitcher;

?>
<?php if ( isset($this->blocks['top-nav']) ) { ?>
    <?php echo $this->blocks['top-nav']; ?>
<?php } else {
    NavBar::begin([
        'brandLabel' => Yii::t('backend', 'Backend Dashboard'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    $menuItems[] = [
        'label' => Yii::t('backend', 'Site'),
        'url'   => Yii::$app->urlManagerFrontend->baseUrl,
    ];

    // display Account and Users to admin+ roles
    if (Yii::$app->user->can(AccessControl::ROLE_ADMIN)) {
    //    $menuItems[] = ['label' => Yii::t('backend', 'Home'),  'url' => ['/backend/index/index']];
        $menuItems[] = ['label' => Yii::t('backend', 'Users'), 'url' => ['/backend/user/index']];
    }

    if ( Yii::$app->user->can(AccessControl::ROLE_TRANSLATOR) ) {
        $menuItems[] = [
            'label'     => Yii::t('backend', 'Translations'),
            'url'       => ['/translations'],
            'active'    => (Yii::$app->controller->route == 'i18n/default/index'),
        ];
    }

    // for admin show link to backend
    // @see https://github.com/yiisoft/yii2/issues/1578
    if ( Yii::$app->user->can(AccessControl::ROLE_ADMIN) ) {
        $menuItems[] = [
            'label' => Yii::t('backend', 'Backend'),
            'url'   => Yii::$app->urlManager->baseUrl,
        ];
    }

    // display Login page to guests of the site
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('backend', 'Login'), 'url' => ['/backend/index/login']];
    }
    // display Logout to all logged in users
    else {
        $menuItems[] = [
            'label'       => Yii::t('backend', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
            'url'         => ['/backend/index/logout'],
            'linkOptions' => ['data-method' => 'post']
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
