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
     * Returns the request Params
     *
     * @param string $type - all|get|post (default all)
     * @return array
     */
    public function getRequestParams($type = 'all')
    {
        return AppHelper::getRequestParams($type);
    }

    /**
     * Returns GET|POST parameter with a given name. If name isn't specified,
     * returns an array of all Request parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     * @return array|mixed
     */
    public function getRequestParam($name = null, $defaultValue = null)
    {
        return AppHelper::getRequestParam($name, $defaultValue);
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
