<?php

namespace frontend\modules\test\controllers;

use common\components\controllers\FrontendController;

class BootstrapController extends FrontendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
