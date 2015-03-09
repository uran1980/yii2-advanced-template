<?php

namespace frontend\modules\test;

use common\rbac\AccessControl;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\test\controllers';

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
                ],
            ],
        ];
    }
}
