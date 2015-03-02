<?php

namespace common\helpers;

use Yii;
use common\helpers\ClientIp;
use yii\helpers\ArrayHelper;

class AppHelper
{
    /**
     * Your application root directory
     *
     * @var string
     */
    const ALIAS_APP = '@app';

    /**
     * Your vendor directory
     *
     * @var string
     */
    const ALIAS_VENDOR = '@vendor';

    /**
     * Your bower directory under @vendor
     *
     * @var string
     */
    const ALIAS_BOWER = '@bower';

    /**
     * Your npm directory under @vendor
     *
     * @var string
     */
    const ALIAS_NPM = '@npm';

    /**
     * Your application files runtime/cache storage folder
     *
     * @var string
     */
    const ALIAS_RUNTIME = '@runtime';

    /**
     * Your application base url path
     *
     * @var string
     */
    const ALIAS_WEB = '@web';

    /**
     * Your application web root
     *
     * @var string
     */
    const ALIAS_WEBROOT = '@webroot';

    /**
     * Your theme base url path
     *
     * @var string
     */
    const ALIAS_THEMES = '@themes';

    /**
     * Your theme web root
     *
     * @var string
     */
    const ALIAS_THEME_BASEPATH = '@themeBasePath';

    /**
     * Your project root
     *
     * @var string
     */
    const ALIAS_ROOT = '@root';

    /**
     * Your application root
     *
     * @var string
     */
    const ALIAS_APP_ROOT = '@appRoot';

    /**
     * Alias for your common root folder under @app
     *
     * @var string
     */
    const ALIAS_COMMON = '@common';

    /**
     * Alias for your frontend root folder under @app
     *
     * @var string
     */
    const ALIAS_FRONTEND = '@frontend';

    /**
     * Alias for your backend root folder under @app
     *
     * @var string
     */
    const ALIAS_BACKEND = '@backend';

    /**
     * Alias for your console root folder under @app
     *
     * @var string
     */
    const ALIAS_CONSOLE = '@console';

    /**
     * Translates a path alias into an actual path.
     *
     * The translation is done according to the following procedure:
     *
     * 1. If the given alias does not start with '@', it is returned back without change;
     * 2. Otherwise, look for the longest registered alias that matches the beginning part
     *    of the given alias. If it exists, replace the matching part of the given alias with
     *    the corresponding registered path.
     * 3. Throw an exception or return false, depending on the `$throwException` parameter.
     *
     * For example, by default '@yii' is registered as the alias to the Yii framework directory,
     * say '/path/to/yii'. The alias '@yii/web' would then be translated into '/path/to/yii/web'.
     *
     * If you have registered two aliases '@foo' and '@foo/bar'. Then translating '@foo/bar/config'
     * would replace the part '@foo/bar' (instead of '@foo') with the corresponding registered path.
     * This is because the longest alias takes precedence.
     *
     * However, if the alias to be translated is '@foo/barbar/config', then '@foo' will be replaced
     * instead of '@foo/bar', because '/' serves as the boundary character.
     *
     * Note, this method does not check if the returned path exists or not.
     *
     * @param string $alias the alias to be translated.
     * @param boolean $throwException whether to throw an exception if the given alias is invalid.
     * If this is false and an invalid alias is given, false will be returned by this method.
     * @return string|boolean the path corresponding to the alias, false if the root alias is not previously registered.
     * @throws InvalidParamException if the alias is invalid while $throwException is true.
     * @see setAlias()
     */
    public static function getAlias($alias, $throwException = true)
    {
        return Yii::getAlias($alias, $throwException);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function getConfigParam($key = null)
    {
        $output = '';                                                           // default

        $params = Yii::$app->params;
        if ( isset($params[$key]) )
            $output = $params[$key];

        return $output;
    }

    /**
     * @return string
     */
    public static function getModuleName()
    {
        return Yii::$app->controller->module->getUniqueId();
    }

    /**
     * @return string
     */
    public static function getControllerName()
    {
        return Yii::$app->controller->getUniqueId();
    }

    /**
     * @return string
     */
    public static function getActionName()
    {
        return Yii::$app->controller->action->getUniqueId();
    }

    /**
     * Returns the request component.
     *
     * @return \yii\web\Request the request component.
     */
    public static function getRequest()
    {
        return Yii::$app->getRequest();
    }

    /**
     * Returns the request Params
     *
     * @param string $type - all|get|post (default all)
     * @return array
     */
    public static function getRequestParams($type = 'all')
    {
        $request    = Yii::$app->getRequest();
        $getParams  = $request->get();
        $postParams = $request->post();

        switch ($type) {
            case 'get':
                $params = $getParams;
                break;

            case 'post':
                $params = $postParams;
                break;

            case 'all':
            default:
                $params = ArrayHelper::merge($getParams, $postParams);
                break;
        }

        return $params;
    }

    /**
     * Returns GET|POST parameter with a given name. If name isn't specified,
     * returns an array of all Request parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     * @return array|mixed
     */
    public static function getRequestParam($name = null, $defaultValue = null)
    {
        $params = self::getRequestParams();
        if ( isset($params[$name]) ) {
            return $params[$name];
        } else {
            return $defaultValue;
        }
    }

    /**
     * @return string
     */
    public static function getRoute()
    {
        return Yii::$app->controller->getRoute();
    }

    /**
     * @return string
     */
    public static function getClientIp()
    {
        return ClientIp::get();
    }

    /**
     * @param string $message
     * @param boolean $removeAfterAccess
     */
    public static function showErrorMessage($message, $removeAfterAccess = true)
    {
        Yii::$app->getSession()->setFlash('error', $message, $removeAfterAccess);
    }

    /**
     * @param string $message
     * @param boolean $removeAfterAccess
     */
    public static function showNoticeMessage($message, $removeAfterAccess = true)
    {
        return self::showWarningMessage($message, $removeAfterAccess);
    }

    /**
     * @param string $message
     * @param boolean $removeAfterAccess
     */
    public static function showWarningMessage($message, $removeAfterAccess = true)
    {
        Yii::$app->getSession()->setFlash('warning', $message, $removeAfterAccess);
    }

    /**
     * @param string $message
     * @param boolean $removeAfterAccess
     */
    public static function showSuccessMessage($message, $removeAfterAccess = true)
    {
        Yii::$app->getSession()->setFlash('success', $message, $removeAfterAccess);
    }


}
