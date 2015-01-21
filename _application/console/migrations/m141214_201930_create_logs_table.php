<?php

use yii\db\Schema;
use yii\db\Migration;

class m141214_201930_create_logs_table extends Migration
{
    public function init()
    {
        $this->db = 'dbLogger';                                                 // custom db adapter for logs

        parent::init();
    }

    /**
     * Чтобы запустить миграцию, необходимо в консоли в корне проекта выполнить:
     *
     * php yii migrate/up
     */
    public function up()
    {
        $tableOptions = null;
        if ( $this->db->driverName == 'mysql' ) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%log}}', [
            'id'        => Schema::TYPE_BIGPK,
            'timestamp' => Schema::TYPE_TIMESTAMP . ' NULL DEFAULT CURRENT_TIMESTAMP',
            'level'     => Schema::TYPE_INTEGER   . ' DEFAULT NULL',
            'category'  => Schema::TYPE_STRING    . ' DEFAULT NULL',
            'log_time'  => Schema::TYPE_FLOAT,
            'prefix'    => Schema::TYPE_TEXT,
            'message'   => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createIndex('idx_log_level', '{{%log}}', 'level');
        $this->createIndex('idx_log_category', '{{%log}}', 'category');
    }

    public function down()
    {
        if ( !YII_ENV_PROD ) {
            $this->dropTable('{{%log}}');
        } else {
            echo "WARNING: " . __CLASS__ . " cannot be reverted.\n";
            return false;
        }
    }
}
