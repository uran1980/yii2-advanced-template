<?php

namespace common\components\controllers;

use yii\web\Controller;
use common\helpers\AppHelper;
use common\helpers\ClientIp;

class MainController extends Controller
{
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

    /**
     * Returns the request component.
     *
     * @return \yii\web\Request the request component.
     */
    public function getRequest()
    {
        return AppHelper::getRequest();
    }

    /**
     * Returns current module name
     *
     * @return string
     */
    public function getModuleName()
    {
        return AppHelper::getModuleName();
    }

    /**
     * Returns current controller name
     *
     * @return string
     */
    public function getControllerName()
    {
        return AppHelper::getControllerName();
    }

    /**
     * Returns current action name
     *
     * @return string
     */
    public function getActionName()
    {
        return AppHelper::getActionName();
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return ClientIp::get();
    }
}
