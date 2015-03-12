<?php

namespace frontend\modules\test\controllers;

use common\components\controllers\FrontendController;

class BootstrapController extends FrontendController
{
    public function init()
    {
        $this->getView()->title = 'Bootstrap Theme';
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
