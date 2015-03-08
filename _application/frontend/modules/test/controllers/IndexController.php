<?php

namespace frontend\modules\test\controllers;

use Yii;
use common\components\controllers\FrontendController;
use common\helpers\AppDebug;
use Stringy\StaticStringy as S;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class IndexController extends FrontendController
{
    public function init()
    {
        parent::init();

        // ------------------------ SET LAYOUT ---------------------------------
        $this->layout = '@common/layouts/blank.php';

        // --------------------------- TITLE -----------------------------------
        $this->getView()->title = S::upperCamelize('test');
    }

    public function actionIndex()
    {
        // --------------------------- TITLE -----------------------------------
        $this->getView()->title .= ' :: ' . S::upperCamelize($this->action->id);

        // TODO

        // debug info ----------------------------------------------------------
        AppDebug::dump([
            'method'        => __METHOD__,
            'line'          => __LINE__,
            'module'        => $this->module->id,
            'controller'    => $this->id,
            'action'        => $this->action->id,
            'dirname'       => StringHelper::dirname(Yii::getAlias('@frontend')),
            'version'       => Yii::getVersion(),
            'clientIp'      => $this->getClientIp(),
            'userIp'        => $this->getRequest()->userIP,
            'language'      => Yii::$app->language,
            'user'          => Yii::$app->getUser(),
            'isGuest'       => Yii::$app->getUser()->isGuest,
            'view params'   => $this->getView()->params,
        ]);
        // ---------------------------------------------------------------------

        return $this->render('index');
    }

    public function actionAppParams()
    {
        // --------------------------- TITLE -----------------------------------
        $this->getView()->title .= ' :: ' . S::upperCamelize($this->action->id);

        // TODO

        // debug info ----------------------------------------------------------
        AppDebug::dump([
            'method'    => __METHOD__,
            'line'      => __LINE__,
            'params'    => Yii::$app->params,

        ]);
        // ---------------------------------------------------------------------

        return $this->render('index');
    }

    public function actionComponents()
    {
        // --------------------------- TITLE -----------------------------------
        $this->getView()->title .= ' :: ' . S::upperCamelize($this->action->id);

        // debug info ----------------------------------------------------------
        AppDebug::dump([
            'method'    => __METHOD__,
            'line'      => __LINE__,
            'dbLogger'  => Yii::$app->get('dbLogger'),
            'db'        => Yii::$app->get('db'),
            'cache'     => Yii::$app->get('cache'),

        ]);
        // ---------------------------------------------------------------------

        return $this->render('index');
    }

    public function actionMultiLang()
    {
        // --------------------------- TITLE -----------------------------------
        $this->getView()->title .= ' :: ' . S::upperCamelize($this->action->id);

        // TODO

        // debug info ----------------------------------------------------------
        AppDebug::dump([
            'method'                                => __METHOD__,
            'line'                                  => __LINE__,
            'moduleId'                              => $this->module->id,
            'controllerId'                          => $this->id,
            'actionId'                              => $this->action->id,
            'language'                              => Yii::$app->language,
            'sourceLanguage'                        => Yii::$app->sourceLanguage,
            'multiLangManager'                      => Yii::$app->get('multiLangManager'),
            'urlManager'                            => Yii::$app->get('urlManager'),
            'Yii::$app->getRequest()->scriptUrl'    => Yii::$app->getRequest()->scriptUrl,
            'Yii::$app->getRequest()->baseUrl'      => Yii::$app->getRequest()->baseUrl,
        ]);
        // ---------------------------------------------------------------------

        return $this->render('index');
    }

    public function actionRequest()
    {
        // --------------------------- TITLE -----------------------------------
        $this->getView()->title .= ' :: ' . S::upperCamelize($this->action->id);

        // TODO

        // debug info ----------------------------------------------------------
        AppDebug::dump([
            'method'    => __METHOD__,
            'line'      => __LINE__,
            'id'        => $this->id,
            'route'     => $this->getRoute(),
            'request'   => $this->getRequest(),
        ]);
        // ---------------------------------------------------------------------

        return $this->render('index');
    }

    public function actionUrl()
    {
        // --------------------------- TITLE -----------------------------------
        $this->getView()->title .= ' :: ' . S::upperCamelize($this->action->id);

        // debug info ----------------------------------------------------------
        AppDebug::dump([
            'method'                    => __METHOD__,
            'line'                      => __LINE__,
            'module'                    => $this->getModuleName(),
            'controller'                => $this->getControllerName(),
            'action'                    => $this->getActionName(),
            '/profile/login'            => Url::toRoute('/profile/login'),
            '/profile/logout'           => Url::toRoute('/profile/logout'),
            '/profile/signup'           => Url::toRoute('/profile/signup'),
            '/request-password-reset'   => Url::toRoute('request-password-reset'),
            'site/captcha'              => Url::toRoute('site/captcha'),
        ]);
        // ---------------------------------------------------------------------

        // TODO

        return $this->render('index');
    }
}
