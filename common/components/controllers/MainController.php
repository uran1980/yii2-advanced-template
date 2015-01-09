<?php

namespace common\components\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\ClientIp;

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
        return ClientIp::get();
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
