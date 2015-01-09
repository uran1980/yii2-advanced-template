<?php

namespace backend\modules\backend;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\backend\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @param string $message
     * @param array $params
     * @param string $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('app-backend', $message, $params, $language);
    }
}
