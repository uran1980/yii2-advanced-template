<?php

namespace common\components\web;

use common\helpers\AppHelper;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * Renders the exception.
     * @param \Exception $exception the exception to be rendered.
     */
    protected function renderException($exception)
    {
        // debug info ----------------------------------------------------------
        \common\helpers\AppDebug::dump([
            'method'        => __METHOD__,
            'line'          => __LINE__,
            'exception'     => $this->htmlEncode($this->convertExceptionToString($exception)),
            'module'        => AppHelper::getModuleName(),
            'controller'    => AppHelper::getControllerName(),
            'action'        => AppHelper::getActionName(),
            'route'         => AppHelper::getRoute(),
            'clientIp'      => AppHelper::getClientIp(),
        ]);
        // ---------------------------------------------------------------------

        parent::renderException($exception);
    }
}
