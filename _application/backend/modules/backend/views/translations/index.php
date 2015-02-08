<?php
/**
 * @var View $this
 * @var SourceMessageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
//use yii\widgets\Pjax;
use Zelenin\yii\modules\I18n\models\search\SourceMessageSearch;
use backend\modules\backend\Module;

$this->title = Module::t('Translations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-index">
    <h3><?= Html::encode($this->title) ?></h3>
    <?php
//    Pjax::begin();
    echo GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'dataColumnClass' => \common\components\grid\DataColumn::className(),
        'showFooter' => true,
        'options' => [
            'class' => 'grid-view table-responsive',
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'value' => function ($model, $index, $dataColumn) {
                    return $model->id;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'message',
                'format' => 'raw',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'value' => function ($model, $index, $widget) {
                    return Html::a($model->message, ['update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                },
            ],
            [
                'attribute' => 'category',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'value' => function ($model, $index, $dataColumn) {
                    return $model->category;
                },
                'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category'),
                'filterInputOptions' => [
                    'class'     => 'form-control chosen-select',
                    'id'        => null,
                    'prompt'    => ' All ',
                ],
            ],
            [
                'attribute' => 'status',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'value' => function ($model, $index, $widget) {
                    return '';
                },
                'filter' => Html::dropDownList($searchModel->formName() . '[status]', $searchModel->status, $searchModel->getStatus(), [
                    'class'  => 'form-control chosen-select',
                    'prompt' => ' All ',
                ]),
            ]
        ]
    ]);
//    Pjax::end();
    ?>
</div>
