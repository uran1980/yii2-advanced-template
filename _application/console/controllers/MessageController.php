<?php

namespace console\controllers;

use common\models\search\SourceMessageSearch;

class MessageController extends \yii\console\controllers\MessageController
{
    /**
     * Extracts messages to be translated from source code.
     *
     * Example from yii console:
     * ```
     * php yii message/extract @common/config/messages.php
     * ```
     *
     * This command will search through source code files and extract
     * messages that need to be translated in different languages.
     *
     * @param string $configFile the path or alias of the configuration file.
     * You may use the "yii message/config" command to generate
     * this file and then customize it for your needs.
     * @throws Exception on failure.
     */
    public function actionExtract($configFile)
    {
        SourceMessageSearch::getInstance()->extract($configFile);
    }

}
