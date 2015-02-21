<?php

use yii\db\Schema;
use yii\db\Migration;

class m141210_115823_create_user_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        try {
            $this->createTable('{{%user}}', [
                'id'                        => Schema::TYPE_PK,
                'username'                  => Schema::TYPE_STRING . ' NOT NULL',
                'email'                     => Schema::TYPE_STRING . ' NOT NULL',
                'user_role'                 => Schema::TYPE_STRING . '(64) NOT NULL DEFAULT "user"',
                'password_hash'             => Schema::TYPE_STRING . ' NOT NULL',
                'status'                    => Schema::TYPE_STRING . ' NOT NULL',
                'auth_key'                  => Schema::TYPE_STRING . '(32) NOT NULL',
                'password_reset_token'      => Schema::TYPE_STRING,
                'profile_activation_token'  => Schema::TYPE_STRING,
                'created_at'                => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at'                => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);

            // Indexes
            $this->createIndex('username',   '{{%user}}', 'username', true);
            $this->createIndex('email',      '{{%user}}', 'email',    true);
            $this->createIndex('user_role',  '{{%user}}', 'user_role');
            $this->createIndex('status',     '{{%user}}', 'status');
            $this->createIndex('created_at', '{{%user}}', 'created_at');
        }
        catch ( Exception $ex ) {
            echo $ex->getMessage();
        }
    }

    public function down()
    {
        if ( !YII_ENV_PROD ) {
            $this->dropTable('{{%user}}');
        } else {
            echo "WARNING: " . __CLASS__ . " cannot be reverted.\n";
            return false;
        }
    }
}
