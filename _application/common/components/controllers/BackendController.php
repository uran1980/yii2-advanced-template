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
                        'controllers'   => ['backend/user'],
                        'actions'       => ['index', 'view', 'create', 'update', 'delete'],
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
                ],
            ], // verbs
        ]; // return
    } // behaviors
}
