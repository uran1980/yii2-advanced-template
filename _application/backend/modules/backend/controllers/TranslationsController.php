<?php

namespace backend\modules\backend\controllers;

use Yii;
use yii\base\Model;
use common\models\search\SourceMessageSearch;
use common\helpers\AppHelper;

class TranslationsController extends \Zelenin\yii\modules\I18n\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRescan()
    {
        // ------------------------- RESCAN MESSAGES ---------------------------
        SourceMessageSearch::getInstance()->extract('@common/config/messages.php');

        // ----------------------- SHOW RESCAN RESULT --------------------------
        AppHelper::showSuccessMessage(Yii::t('backend', 'Rescan successfully completed.'));

        // ---------------------------- REDIRECT -------------------------------
        return $this->redirect(['/backend/translations/index']);
    }

    public function actionClearCache()
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/backend/translations/index']);
        }

        // ------------------------ SET JSON RESPONSE --------------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // ---------------------- SET DEFAULT RESPONSE -------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('backend', 'An unexpected error occured!'),
        );

        // -------------------------- CLEAR CACHE ------------------------------
        // TODO

        // debug test ----------------------------------------------------------
        $response['status']  = 'success';
        $response['message'] = 'TODO clear cache...';
        // ---------------------------------------------------------------------

        return $response;
    }

    public function actionSave($id)
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/backend/translations/index']);
        }

        // ----------------------- SET JSON RESPONSE ---------------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // --------------------- SET DEFAULT RESPONSE --------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('backend', 'An unexpected error occured!'),
        );

        // --------------------- SAVE TRANSLATION BY ID ------------------------
        // @see vendor\zelenin\yii2-i18n-module\controllers\DefaultController::actionUpdate
        $model = $this->findModel($id);
        $model->initMessages();

        if ( Model::loadMultiple($model->messages, Yii::$app->getRequest()->post())
             && Model::validateMultiple($model->messages) )
        {
            $model->saveMessages();

            // TODO clear cache...

            $response['status']  = 'success';
            $response['message'] = 'Translation successfuly saved.';
            $response['params']  = AppHelper::getRequestParams();
        }

        return $response;
    }

    public function actionDelete()
    {
        // ---------------------- CHECK IS AJAX REQUEST ------------------------
        if ( !Yii::$app->getRequest()->isAjax ) {
            return $this->redirect(['/translations']);
        }

        // ----------------------- SET JSON RESPONSE ---------------------------
        // @see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;

        // --------------------- SET DEFAULT RESPONSE --------------------------
        $response = array(
            'status'  => 'error',
            'message' => Yii::t('backend', 'An unexpected error occured!'),
        );

        // -------------------- DELETE TRANSLATION BY ID -----------------------
        // TODO

        // debug test ----------------------------------------------------------
        $response['status']   = 'success';
        $response['message']  = 'TODO delete translation...';
        // ---------------------------------------------------------------------

        return $response;
    }
}
