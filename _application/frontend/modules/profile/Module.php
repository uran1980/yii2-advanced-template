<?php

namespace frontend\modules\profile;

use common\rbac\AccessControl;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\profile\controllers';

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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
