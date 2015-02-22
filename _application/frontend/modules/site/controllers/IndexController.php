<?php

namespace frontend\modules\site\controllers;

use common\components\controllers\FrontendController;
use common\helpers\AppHelper;
use frontend\modules\site\models\forms\ContactForm;
use yii\helpers\ArrayHelper;
use Yii;

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
        return ArrayHelper::merge(parent::actions(), [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ]);
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                AppHelper::showSuccessMessage(Yii::t('site', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                AppHelper::showSuccessMessage(Yii::t('site', 'There was an error sending email.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

}
