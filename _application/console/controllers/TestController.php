<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use common\components\log\AppLogger;
use vova07\users\helpers\Security;
use common\helpers\AppDebug;

class TestController extends \yii\console\Controller
{
    /**
     * @var string the default command action.
     */
    public $defaultAction = 'test';

    /**
     * The command "yii test/test test" will call "actionTest('test')"
     */
    public function actionTest()
    {
        // debug info ----------------------------------------------------------
        $debugInfo = print_r(array(
            'method'    => __METHOD__,
            'line'      => __LINE__,
            'test'      => 'TEST',
//            'dbLogger'  => Yii::$app->get('dbLogger'),
        ), true) . PHP_EOL;
        // ---------------------------------------------------------------------

        AppLogger::info($debugInfo, AppLogger::CATEGORY_CONSOLE);

        $this->stdout($debugInfo, Console::BG_YELLOW);
    }

    public function actionInsertUsers()
    {
        $time  = time();
        $users = [
            'admin' => [
                'username'      => 'admin',
                'email'         => 'admin@demo.com',
                'password_hash' => Yii::$app->security->generatePasswordHash('admin12345'),
                'auth_key'      => Yii::$app->security->generateRandomString(),
                'token'         => Security::generateExpiringRandomString(),
                'role'          => 'superadmin',
                'status_id'     => 1,
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
            'uran1980' => [
                'username'      => 'uran1980',
                'email'         => 'uran1980@gmail.com',
                'password_hash' => Yii::$app->security->generatePasswordHash('uran198012345'),
                'auth_key'      => Yii::$app->security->generateRandomString(),
                'token'         => Security::generateExpiringRandomString(),
                'role'          => 'admin',
                'status_id'     => 1,
                'created_at'    => $time,
                'updated_at'    => $time,
            ],
        ];
        $sql = 'INSERT INTO {{%users}} (`username`, `email`, `password_hash`, `auth_key`, `token`, `role`, `status_id`, `created_at`, `updated_at`) VALUES' . PHP_EOL;
        foreach ( $users as $data ) {
            if ( !empty($data) ) {
                $sql .= '("' . implode('","', $data) . '"),';
            }
        }
        $sql = trim($sql, ',') . ';'. PHP_EOL;

        $this->stdout($sql);
    }

    public function actionInsertProfiles()
    {
        $profiles = [
            'admin' => [
                'user_id'    => 1,
                'name'       => 'Administration',
                'surname'    => 'Site',
                'avatar_url' => '',
            ],
            'user' => [
                'user_id'    => 2,
                'name'       => 'uran1980',
                'surname'    => 'uran1980',
                'avatar_url' => '',
            ],
        ];

        $sql = 'INSERT INTO {{%profiles}} (`user_id`, `name`, `surname`, `avatar_url`) VALUES' . PHP_EOL;
        foreach ( $profiles as $data ) {
            if ( !empty($data) ) {
                $sql .= '("' . implode('","', $data) . '"),';
            }
        }
        $sql = trim($sql, ',') . ';' . PHP_EOL;

        $this->stdout($sql);
    }

    public function actionAliases()
    {
        $this->stdout(AppDebug::dump(Yii::$aliases, 'console'));
    }

}
