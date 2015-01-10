<?php
namespace frontend\modules\site\controllers;

use common\components\controllers\FrontendController;
use frontend\modules\site\models\ContactForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

use yii\helpers\Url;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and profile activation, password reset.
 */
class IndexController extends FrontendController
{
    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

// -----------------------------------------------------------------------------
//                                  STATIC PAGES
// -----------------------------------------------------------------------------

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
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->contact(Yii::$app->params['adminEmail']))
            {
                Yii::$app->session->setFlash('success',
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        }
        else
        {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


}
