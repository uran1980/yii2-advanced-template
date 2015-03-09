<?php

namespace backend\modules\backend;

use common\rbac\AccessControl;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\backend\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [AccessControl::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }
}
