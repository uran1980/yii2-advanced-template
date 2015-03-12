<?php

namespace frontend\modules\test\controllers;

use Yii;
use common\components\controllers\FrontendController;
use Stringy\StaticStringy as S;
use common\components\log\AppLogger;
use yii\helpers\ArrayHelper;
use common\rbac\AccessControl;

class LoggerController extends FrontendController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [AccessControl::ROLE_ADMIN],
                    ],
                ],
            ],
        ]);
    }

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

        // log -----------------------------------------------------------------
        AppLogger::log([
            'method'        => __METHOD__,
            'line'          => __LINE__,
            'requestParams' => Yii::$app->request->getQueryParams(),
        ], AppLogger::WARNING, AppLogger::CATEGORY_TEST);
        // ---------------------------------------------------------------------

        return $this->render('/index/index');
    }

}
