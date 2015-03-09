<?php

namespace common\components\controllers;

use common\rbac\AccessControl;
use yii\filters\VerbFilter;

class BackendController extends MainController
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
                        'allow' => true,
                        'roles' => [AccessControl::ROLE_ADMIN],
                    ],
                    [
                        'controllers'   => ['backend/index'],
                        'actions'       => ['login', 'error'],
                        'allow'         => true,
                    ],
                    [
                        'controllers'   => ['backend/index'],
                        'actions'       => ['logout'],
                        'allow'         => true,
                        'roles'         => ['@'],
                    ],
                    [
                        'controllers'   => ['backend/index'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_ADMIN],
                    ],
                    [
                        'controllers'   => ['backend/user'],
//                        'actions'       => ['index', 'view', 'create', 'update', 'delete'],
                        'allow'         => true,
                        'roles'         => [AccessControl::ROLE_ADMIN],
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
                    'logout' => ['post'],
                ],
            ], // verbs
        ]; // return
    } // behaviors
}
