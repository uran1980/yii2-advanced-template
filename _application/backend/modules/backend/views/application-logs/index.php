<?php

/* @var $searchModel yii\debug\models\search\DbLog */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\log\Logger;
use Stringy\StaticStringy as Stringy;

\common\assets\AppCommonAsset::register($this);

$this->title = Yii::t('backend', 'Application Log Messages');
?>

<div class="backend-application-logs-index">
    <h1><?php echo Yii::t('backend', 'Application Log Messages'); ?></h1>

<?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'dataColumnClass' => \common\components\grid\DataColumn::className(),
        'id' => 'dblog-panel-detailed-grid',
        'showFooter' => true,
        'options' => [
            'class' => 'detail-grid-view table-responsive',
        ],
        'filterModel' => $searchModel,
        'filterUrl' => $panel->getUrl(),
        'columns' => [
            [
                'class' => yii\grid\SerialColumn::className(),
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
            ],
            [
                'attribute' => 'timestamp',
                'value' => function ($data) {
                    if ( isset($data['time']) ) {
                        $timeInSeconds = $data['time'] / 1000;
                        $millisecondsDiff = (int) (($timeInSeconds - (int) $timeInSeconds) * 1000);

                        return date('H:i:s.', $timeInSeconds) . sprintf('%03d', $millisecondsDiff);
                    } else {
                        return $data['timestamp'];
                    }
                },
                'headerOptions' => [
                    'class' => 'sort-numerical text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'sort-numerical text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'nowrap font-size-10px text-align-center',
                ],
            ],
            [
                'attribute' => 'level',
                'value' => function ($data) {
                    switch ($data['level']) {
                        case Logger::LEVEL_ERROR:   $class = 'label label-danger';  break;
                        case Logger::LEVEL_WARNING: $class = 'label label-warning'; break;
                        case Logger::LEVEL_INFO:    $class = 'label label-primary'; break;
                        default:                    $class = 'label label-default'; break;
                    }

                    return Html::tag('span', Logger::getLevelName($data['level']), ['class' => $class]);
                },
                'format' => 'html',
                'filter' => [
                    Logger::LEVEL_TRACE     => ' Trace ',
                    Logger::LEVEL_INFO      => ' Info ',
                    Logger::LEVEL_WARNING   => ' Warning ',
                    Logger::LEVEL_ERROR     => ' Error ',
                ],
                'filterInputOptions' => [
                    'class'     => 'form-control chosen-select',
                    'id'        => null,
                    'prompt'    => ' All ',
                ],
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
            ],
            [
                'attribute' => 'category',
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'font-size-10px',
                ],
            ],
            [
                'attribute' => 'message',
                'value' => function ($data) {
                    $description    = Html::encode(is_string($data['message'])
                                    ? $data['message']
                                    : VarDumper::export($data['message']));
                    $message        = '<a href="javascript:;" class="spoiler-title" data-title="" data-content="'
                                    . $description . '">' . Stringy::substr(Stringy::collapseWhitespace($description), 0, 60, 'UTF-8') . '...' . '</a>';
                    $trace          = '';

                    if (!empty($data['trace'])) {
                        $trace .= Html::ul($data['trace'], [
                            'class' => 'trace',
                            'item' => function ($trace) {
                                return "<li>{$trace['file']} ({$trace['line']})</li>";
                            }
                        ]);
                    }

                    $message .= '<div class="spoiler-content"><strong>Message: </strong><br /><pre>' . $description . '</pre>'
                              . (!empty($trace) ? '<br /><p><strong>Trace: </strong>' . $trace . '</p>' : '') . '</div>';

                    return $message;
                },
                'format' => 'html',
                'options' => [
                    'width' => '50%',
                ],
                'headerOptions' => [
                    'class' => 'text-align-center',
                ],
                'footerOptions' => [
                    'class' => 'text-align-center font-weight-bold th',
                ],
                'contentOptions' => [
                    'class' => 'spoiler',
                ],
            ],
        ],
    ]);
?>
</div>