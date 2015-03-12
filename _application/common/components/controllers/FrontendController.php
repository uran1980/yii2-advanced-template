<?php

namespace common\components\controllers;

use common\rbac\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class FrontendController extends MainController
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['site/index'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => [AccessControl::ROLE_ADMIN],
                    ],
                    [
                        'controllers'   => ['site/article'],
                        'actions'       => ['create', 'update', 'admin', 'delete'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_EDITOR],
                    ],
                    [
                        'controllers'   => ['site/article'],
                        'actions'       => ['index', 'view'],
                        'allow'         => true,
                    ],
                ], // rules
            ], // access
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'logout' => ['POST'],
                ],
            ], // verbs
        ]; // return
    } // behaviors

    /**
     * Redirects the browser to the client's profile page.
     *
     * You can use this method in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and redirect to home page
     * return $this->goToProfile();
     * ```
     *
     * @return Response the current response object
     */
    public function goToProfile()
    {
        return Yii::$app->getResponse()->redirect(Yii::$app->getUrlManager()->createUrl('/profile/index/index'));
    }
}
