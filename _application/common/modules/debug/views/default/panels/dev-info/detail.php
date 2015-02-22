<?php
/* @var $panel common\modules\debug\panels\DevInfoPanel */

use yii\bootstrap\Tabs;

?>
<a href="#yii-debug-toolbar" class="scroll-to-top-link" style="display: none;"><?php
    echo Yii::t('common', 'Scroll to top'); ?></a>

<h1>Dev Info</h1>

<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => 'Aliases',
            'content' => $this->render('table', [
                'caption'       => 'Application Aliases',
                'description'   => '<pre class="well">Yii::$aliases;</pre>',
                'values'        => $panel->data['aliases'],
            ]),
            'active' => true,
        ],
        [
            'label'     => 'Yii::$app->params',
            'content'   => '<h3>Yii::$app->params</h3><p><pre>' . print_r(Yii::$app->params, true) . '</pre></p>',
        ],
        [
            'label'     => 'TODO',
            'content'   => '<h3>TODO</h3><p>TODO</p>',
        ],
        [
            'label'     => 'TODO',
            'content'   => '<h3>TODO</h3><p>TODO</p>',
        ],
    ],
]);