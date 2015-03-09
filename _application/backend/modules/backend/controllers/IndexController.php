<?php

namespace backend\modules\backend\controllers;

use Yii;
use common\rbac\AccessControl;
use common\components\controllers\BackendController;
use common\models\forms\LoginForm;

/**
 * Index controller
 */
class IndexController extends BackendController
{
    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in the user if his profile is activated,
     * if not, displays standard error message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['LoginWithEmail'];

        // if "login with email" is true we instantiate LoginForm in "lwe" scenario
        $lwe ? $model = new LoginForm(['scenario' => 'LoginWithEmail']) : $model = new LoginForm() ;

        // everything went fine, log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            AccessControl::checkRoleAssignment();

            return $this->goBack();
        }
        // errors will be displayed
        else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
