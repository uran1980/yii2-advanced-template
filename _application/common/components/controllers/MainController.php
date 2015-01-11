<?php

namespace common\components\controllers;

use Yii;
use yii\web\Controller;

class MainController extends Controller
{
    /**
     * Returns the request component.
     * @return \yii\web\Request the request component.
     */
    public function getRequest()
    {
        return Yii::$app->getRequest();
    }

    /**
     * Returns current module name
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->module->id;
    }

    /**
     * Returns current controller name
     *
     * @return string
     */
    public function getControllerName()
    {
        return Yii::$app->controller->id;
    }

    /**
     * The controller ID that is prefixed with the module ID (if any).
     *
     * @return string
     */
    public function getControllerUniqueName()
    {
        return Yii::$app->controller->uniqueId;
    }

    /**
     * Returns current action name
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->action->id;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        $userIp = Yii::$app->getRequest()->getUserIP();

        if ( null === $userIp ) {
           $userIp = \common\helpers\ClientIp::get();
        }

        return $userIp;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
