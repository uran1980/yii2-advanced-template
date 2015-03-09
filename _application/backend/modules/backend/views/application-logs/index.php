<?php

/* @var $searchModel yii\debug\models\search\DbLog */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */

use yii\helpers\Html;
use common\components\grid\GridView;
use common\components\grid\SerialColumn;
use common\modules\debug\models\search\DbLog;
use yii\helpers\VarDumper;
use yii\log\Logger;
use Stringy\StaticStringy as Stringy;

/** @var DbLog $searchModel */
$searchModel = DbLog::getInstance();

$this->title = Yii::t('backend', 'Application DB Log Messages');
?>

<div class="backend-application-logs-index">
    <h1><?php echo $this->title; ?></h1>

<?php
    echo GridView::widget([
        'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => SerialColumn::className(),
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
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
            ],
            [
                'attribute' => 'category',
                'contentOptions' => [
                    'class' => 'font-size-10px text-align-center',
                ],
                'headerOptions' => [
                    'width' => '200',
                ],
            ],
            [
                'attribute' => 'message',
                'value' => function ($data) {
                    $description    = Html::encode(is_string($data['message'])
                                    ? $data['message']
                                    : VarDumper::export($data['message']));
                    $message        = '<a href="javascript: void(0);" class="spoiler-title" data-title="" data-content="'
                                    . $description . '">' . Stringy::substr(Stringy::collapseWhitespace($description), 0, 80, 'UTF-8') . '...' . '</a>';
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
                'contentOptions' => [
                    'class' => 'spoiler',
                ],
            ],
        ],
    ]);
?>
</div>