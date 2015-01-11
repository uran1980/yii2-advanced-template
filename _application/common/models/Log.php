<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\log\Logger;

/**
 * Log model
 *
 * @property integer    $id
 * @property timestamp  $timestamp
 * @property integer    $level
 * @property string     $category
 * @property float      $log_time
 * @property string     $prefix
 * @property string     $message
 */
class Log extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * Returns the database connection used by this AR class.
     *
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbLogger');
    }

    /**
     * @see http://www.yiiframework.com/doc-2.0/guide-output-data-providers.html
     *
     * @param array $config
     * @return \yii\data\ActiveDataProvider
     */
    public static function getDataProvider($config = [])
    {
        $defaultConfig = [
            'db' => self::getDb(),
            'query' => self::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['timestamp', 'level', 'category', 'message'],
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ],
            ],
        ];

        if ( is_array($config) ) {
            $config = \yii\helpers\ArrayHelper::merge($defaultConfig, $config);
        } else {
            $config = $defaultConfig;
        }

        $dataProvider = new ActiveDataProvider($config);

        return $dataProvider;
    }

    /**
     * @return int
     */
    public static function getTotalCount()
    {
        return self::find()->count();
    }

    /**
     * @return int
     */
    public static function getErrorCount()
    {
        $output = self::find()
            ->where(['level' => Logger::LEVEL_ERROR])
            ->count()
        ;

        return $output;
    }

    /**
     * @return int
     */
    public static function getWarningCount()
    {
        $output = self::find()
            ->where(['level' => Logger::LEVEL_WARNING])
            ->count()
        ;

        return $output;
    }

}
