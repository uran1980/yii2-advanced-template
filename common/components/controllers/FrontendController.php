<?php

namespace common\components\controllers;

use common\rbac\AccessControl;
use yii\filters\VerbFilter;

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
                        'controllers' => ['site/index', 'site/foo'],
                        'allow' => true,
                    ],
                    [
                        'controllers'   => ['site/article'],
                        'actions'       => ['index', 'view', 'create', 'update', 'delete', 'admin'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_ADMIN],
                    ],
                    [
                        'controllers'   => ['site/article'],
                        'actions'       => ['create', 'update', 'admin'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_EDITOR],
                    ],
                    [
                        'controllers'   => ['site/article'],
                        'actions'       => ['index', 'view'],
                        'allow'         => true
                    ],
                    [
                        // other rules
                    ],
                ], // rules
            ], // access
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs
        ]; // return
    } // behaviors
}
