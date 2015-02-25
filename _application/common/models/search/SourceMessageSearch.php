<?php

namespace common\models\search;

use Yii;
use yii\console\Exception;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\i18n\GettextPoFile;
use yii\helpers\Json;

class SourceMessageSearch extends \Zelenin\yii\modules\I18n\models\search\SourceMessageSearch
{
    const STATUS_ALL = 0;

    /**
     * @var SourceMessageSearch
     */
    protected static $_instance = null;

    /**
     * @var boolean whether to enable ANSI color in the output.
     * If not set, ANSI color will only be enabled for terminals that support it.
     */
    public $color;

    /**
     * @var array
     */
    protected $locations = [];

    /**
     * @var array
     */
    protected $config = [
        'translator'    => 'Yii::t',
        'overwrite'     => false,
        'removeUnused'  => false,
        'sort'          => false,
        'format'        => 'php',
    ];

    /**
     * @return SourceMessageSearch
     */
    public static function getInstance()
    {
        if ( null === self::$_instance )
            self::$_instance = new self();

        return self::$_instance;
    }

    /**
     * @param array $item
     * @return string
     */
    public static function isActiveTranslation($item)
    {
        $output = '';                                                           // default

        $params = Yii::$app->request->getQueryParams();
        unset($params['page'], $params['sort']);
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') === Yii::$app->controller->getRoute()) {
                if ( empty($params) && count($item['url']) == 1 )
                    return ' active ';
            }
            unset($item['url']['#']);
            if ( isset($params['SourceMessageSearch'], $params['SourceMessageSearch']['status']) ) {
                if ( count($item['url']) > 1 ) {
                    foreach ( $item['url'] as $name => $value ) {
                        if ( $params['SourceMessageSearch']['status'] == $value ) {
                            return ' active ';
                        } elseif ( $name == 'SourceMessageSearch'
                                   && isset($item['current'])
                                   && $params['SourceMessageSearch']['status'] == $item['current'] )
                        {
                            return ' active ';
                        }
                    }
                } elseif ( empty($params['SourceMessageSearch']['status']) ) {
                    return ' active ';
                }
            } elseif ( isset($item['current']) && $item['current'] == self::STATUS_ALL ) {
                return ' active ';
            }
        }

        return $output;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'category'  => Yii::t('common', 'Category'),
            'message'   => Yii::t('common', 'Message'),
            'status'    => Yii::t('common', 'Translation status'),
            'location'  => Yii::t('common', 'Location'),
        ];
    }

    /**
     * Extracts messages to be translated from source code.
     *
     * This command will search through source code files and extract
     * messages that need to be translated in different languages.
     *
     * @param string $configFile the path or alias of the configuration file.
     * You may use the "yii message/config" command to generate
     * this file and then customize it for your needs.
     * @throws Exception on failure.
     */
    public function extract($configFile)
    {
        $configFile = Yii::getAlias($configFile);
        if (!is_file($configFile)) {
            throw new Exception("The configuration file does not exist: $configFile");
        }

        $this->config = array_merge($this->config, require($configFile));

        if (!isset($this->config['sourcePath'], $this->config['languages'])) {
            throw new Exception('The configuration file must specify "sourcePath" and "languages".');
        }
        if (!is_dir($this->config['sourcePath'])) {
            throw new Exception("The source path {$this->config['sourcePath']} is not a valid directory.");
        }
        if (empty($this->config['format']) || !in_array($this->config['format'], ['php', 'po', 'db'])) {
            throw new Exception('Format should be either "php", "po" or "db".');
        }
        if (in_array($this->config['format'], ['php', 'po'])) {
            if (!isset($this->config['messagePath'])) {
                throw new Exception('The configuration file must specify "messagePath".');
            } elseif (!is_dir($this->config['messagePath'])) {
                throw new Exception("The message path {$this->config['messagePath']} is not a valid directory.");
            }
        }
        if (empty($this->config['languages'])) {
            throw new Exception("Languages cannot be empty.");
        }

        $files    = FileHelper::findFiles(realpath($this->config['sourcePath']), $this->config);
        $messages = [];
        foreach ($files as $file) {
            $messages = array_merge_recursive($messages, $this->extractMessages($file, $this->config['translator']));
        }
        if (in_array($this->config['format'], ['php', 'po'])) {
            foreach ($this->config['languages'] as $language) {
                $dir = $this->config['messagePath'] . DIRECTORY_SEPARATOR . $language;
                if (!is_dir($dir)) {
                    @mkdir($dir);
                }
                if ($this->config['format'] === 'po') {
                    $catalog = isset($this->config['catalog']) ? $this->config['catalog'] : 'messages';
                    $this->saveMessagesToPO($messages, $dir, $this->config['overwrite'], $this->config['removeUnused'], $this->config['sort'], $catalog);
                } else {
                    $this->saveMessagesToPHP($messages, $dir, $this->config['overwrite'], $this->config['removeUnused'], $this->config['sort']);
                }
            }
        } elseif ($this->config['format'] === 'db') {
            $db = \Yii::$app->get(isset($this->config['db']) ? $this->config['db'] : 'db');
            if (!$db instanceof \yii\db\Connection) {
                throw new Exception('The "db" option must refer to a valid database application component.');
            }
            $sourceMessageTable = isset($this->config['sourceMessageTable']) ? $this->config['sourceMessageTable'] : '{{%source_message}}';
            $messageTable = isset($this->config['messageTable']) ? $this->config['messageTable'] : '{{%message}}';
            $this->saveMessagesToDb(
                $messages,
                $db,
                $sourceMessageTable,
                $messageTable,
                $this->config['removeUnused'],
                $this->config['languages']
            );
        }
    }

    /**
     * Saves messages to database
     *
     * @param array $messages
     * @param \yii\db\Connection $db
     * @param string $sourceMessageTable
     * @param string $messageTable
     * @param boolean $removeUnused
     * @param array $languages
     */
    public function saveMessagesToDb($messages, $db, $sourceMessageTable, $messageTable, $removeUnused, $languages)
    {
//        // debug info ----------------------------------------------------------
//        return \common\helpers\AppDebug::dump(array(
//            '$messages'        => $messages,
//            '$this->locations' => $this->locations,
//        ));
//        // ---------------------------------------------------------------------

        $q = new \yii\db\Query;
        $current = [];

        foreach ($q->select(['id', 'category', 'message'])->from($sourceMessageTable)->all() as $row) {
            $current[$row['category']][$row['id']] = $row['message'];
        }

        $new = [];
        $obsolete = [];

        foreach ($messages as $category => $msgs) {
            $msgs = array_unique($msgs);

            if (isset($current[$category])) {
                $new[$category] = array_diff($msgs, $current[$category]);
                $obsolete += array_diff($current[$category], $msgs);
            } else {
                $new[$category] = $msgs;
            }
        }

        foreach (array_diff(array_keys($current), array_keys($messages)) as $category) {
            $obsolete += $current[$category];
        }

        if (!$removeUnused) {
            foreach ($obsolete as $pk => $m) {
                if (mb_substr($m, 0, 2) === '@@' && mb_substr($m, -2) === '@@') {
                    unset($obsolete[$pk]);
                }
            }
        }

        $obsolete = array_keys($obsolete);
        $this->stdout("Inserting new messages...");
        $savedFlag = false;

        foreach ($new as $category => $msgs) {
            foreach ($msgs as $m) {
                $savedFlag  = true;
                $msgHash    = md5($m);

                $db->createCommand()
                    ->insert($sourceMessageTable, [
                        'category'  => $category,
                        'hash'      => $msgHash,
                        'message'   => $m,
                        'location'  => $this->extractLocations($category, $m),
                    ])
                    ->execute()
                ;
                $lastID = $db->getLastInsertID();
                foreach ($languages as $language) {
                    $db->createCommand()
                        ->insert($messageTable, [
                           'id'         => $lastID,
                           'language'   => $language,
                            'hash'      => $msgHash,
                        ])
                        ->execute()
                    ;
                }
            }
        }

        $this->stdout($savedFlag ? "saved." . PHP_EOL : "Nothing new...skipped." . PHP_EOL);
        $this->stdout($removeUnused ? "Deleting obsoleted messages..." . PHP_EOL : "Updating obsoleted messages..." . PHP_EOL);

        if (empty($obsolete)) {
            $this->stdout("Nothing obsoleted!...skipped." . PHP_EOL);
        } else {
            if ($removeUnused) {
                $db->createCommand()
                   ->delete($sourceMessageTable, ['in', 'id', $obsolete])->execute();
                $this->stdout("deleted." . PHP_EOL);
            } else {
                $db->createCommand()
                    ->update(
                        $sourceMessageTable,
                        ['message' => new \yii\db\Expression("CONCAT('@@',message,'@@')")],
                        ['in', 'id', $obsolete]
                    )
                    ->execute()
                ;
                $this->stdout("updated." . PHP_EOL);
            }
        }
    }

    /**
     * @param string $category
     * @param string $message
     * @return string
     */
    protected function extractLocations($category, $message)
    {
        $output  = [];
        $msgHash = md5($message);

        foreach ( $this->locations[$category] as $location ) {
            if ( isset($location[$msgHash]) ) {
                $output[] = $location[$msgHash];
            }
        }

        return Json::encode($output);
    }

    /**
     * Extracts messages from a file
     *
     * @param string $fileName name of the file to extract messages from
     * @param string $translator name of the function used to translate messages
     * @return array
     */
    protected function extractMessages($fileName, $translator)
    {
        $coloredFileName = Console::ansiFormat($fileName, [Console::FG_CYAN]);
        $this->stdout("Extracting messages from $coloredFileName...\n");

        $subject  = file_get_contents($fileName);
        $messages = [];
        if (!is_array($translator)) {
            $translator = [$translator];
        }
        foreach ($translator as $currentTranslator) {
            $translatorTokens = token_get_all('<?php ' . $currentTranslator);
            array_shift($translatorTokens);

            $translatorTokensCount = count($translatorTokens);
            $matchedTokensCount = 0;
            $buffer = [];

            $tokens = token_get_all($subject);
            foreach ($tokens as $token) {
                // finding out translator call
                if ($matchedTokensCount < $translatorTokensCount) {
                    if ($this->tokensEqual($token, $translatorTokens[$matchedTokensCount])) {
                        $matchedTokensCount++;
                    } else {
                        $matchedTokensCount = 0;
                    }
                } elseif ($matchedTokensCount === $translatorTokensCount) {
                    // translator found
                    // end of translator call or end of something that we can't extract
                    if ($this->tokensEqual(')', $token)) {
                        if (isset($buffer[0][0], $buffer[1], $buffer[2][0]) && $buffer[0][0] === T_CONSTANT_ENCAPSED_STRING && $buffer[1] === ',' && $buffer[2][0] === T_CONSTANT_ENCAPSED_STRING) {
                            // is valid call we can extract

                            $category = stripcslashes($buffer[0][1]);
                            $category = mb_substr($category, 1, mb_strlen($category) - 2);

                            $message = stripcslashes($buffer[2][1]);
                            $message = mb_substr($message, 1, mb_strlen($message) - 2);

                            $messages[$category][]        = $message;
                            $this->locations[$category][] = [md5($message) => str_replace(realpath($this->config['sourcePath']), '', $fileName)];
                        } else {
                            // invalid call or dynamic call we can't extract
                            $line = Console::ansiFormat($this->getLine($buffer), [Console::FG_CYAN]);
                            $skipping = Console::ansiFormat('Skipping line', [Console::FG_YELLOW]);
                            $this->stdout("$skipping $line. Make sure both category and message are static strings.\n");
                        }

                        // prepare for the next match
                        $matchedTokensCount = 0;
                        $buffer = [];
                    } elseif ($token !== '(' && isset($token[0]) && !in_array($token[0], [T_WHITESPACE, T_COMMENT])) {
                        // ignore comments, whitespaces and beginning of function call
                        $buffer[] = $token;
                    }
                }
            }
        }

        return $messages;
    }

    /**
     * Finds out if two PHP tokens are equal
     *
     * @param array|string $a
     * @param array|string $b
     * @return boolean
     * @since 2.0.1
     */
    protected function tokensEqual($a, $b)
    {
        if (is_string($a) && is_string($b)) {
            return $a === $b;
        } elseif (isset($a[0], $a[1], $b[0], $b[1])) {
            return $a[0] === $b[0] && $a[1] == $b[1];
        }

        return false;
    }

    /**
     * Finds out a line of the first non-char PHP token found
     *
     * @param array $tokens
     * @return int|string
     * @since 2.0.1
     */
    protected function getLine($tokens)
    {
        foreach ($tokens as $token) {
            if (isset($token[2])) {
                return $token[2];
            }
        }

        return 'unknown';
    }

    /**
     * Writes messages into PHP files
     *
     * @param array $messages
     * @param string $dirName name of the directory to write to
     * @param boolean $overwrite if existing file should be overwritten without backup
     * @param boolean $removeUnused if obsolete translations should be removed
     * @param boolean $sort if translations should be sorted
     */
    protected function saveMessagesToPHP($messages, $dirName, $overwrite, $removeUnused, $sort)
    {
        foreach ($messages as $category => $msgs) {
            $file = str_replace("\\", '/', "$dirName/$category.php");
            $path = dirname($file);
            FileHelper::createDirectory($path);
            $msgs = array_values(array_unique($msgs));
            $coloredFileName = Console::ansiFormat($file, [Console::FG_CYAN]);
            $this->stdout("Saving messages to $coloredFileName...\n");
            $this->saveMessagesCategoryToPHP($msgs, $file, $overwrite, $removeUnused, $sort, $category);
        }
    }

    /**
     * Writes category messages into PHP file
     *
     * @param array $messages
     * @param string $fileName name of the file to write to
     * @param boolean $overwrite if existing file should be overwritten without backup
     * @param boolean $removeUnused if obsolete translations should be removed
     * @param boolean $sort if translations should be sorted
     * @param string $category message category
     */
    protected function saveMessagesCategoryToPHP($messages, $fileName, $overwrite, $removeUnused, $sort, $category)
    {
        if (is_file($fileName)) {
            $existingMessages = require($fileName);
            sort($messages);
            ksort($existingMessages);
            if (array_keys($existingMessages) == $messages) {
                return $this->stdout("Nothing new in \"$category\" category... Nothing to save.\n\n", Console::FG_GREEN);
            }
            $merged = [];
            $untranslated = [];
            foreach ($messages as $message) {
                if (array_key_exists($message, $existingMessages) && strlen($existingMessages[$message]) > 0) {
                    $merged[$message] = $existingMessages[$message];
                } else {
                    $untranslated[] = $message;
                }
            }
            ksort($merged);
            sort($untranslated);
            $todo = [];
            foreach ($untranslated as $message) {
                $todo[$message] = '';
            }
            ksort($existingMessages);
            foreach ($existingMessages as $message => $translation) {
                if (!isset($merged[$message]) && !isset($todo[$message]) && !$removeUnused) {
                    if (!empty($translation) && strncmp($translation, '@@', 2) === 0 && substr_compare($translation, '@@', -2, 2) === 0) {
                        $todo[$message] = $translation;
                    } else {
                        $todo[$message] = '@@' . $translation . '@@';
                    }
                }
            }
            $merged = array_merge($todo, $merged);
            if ($sort) {
                ksort($merged);
            }
            if (false === $overwrite) {
                $fileName .= '.merged';
            }
            $this->stdout("Translation merged.\n");
        } else {
            $merged = [];
            foreach ($messages as $message) {
                $merged[$message] = '';
            }
            ksort($merged);
        }


        $array = VarDumper::export($merged);
        $content = <<<EOD
<?php
/**
 * Message translations.
 *
 * This file is automatically generated by 'yii message' command.
 * It contains the localizable messages extracted from source code.
 * You may modify this file by translating the extracted messages.
 *
 * Each array element represents the translation (value) of a message (key).
 * If the value is empty, the message is considered as not translated.
 * Messages that no longer need translation will have their translations
 * enclosed between a pair of '@@' marks.
 *
 * Message string can be used with plural forms format. Check i18n section
 * of the guide for details.
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
return $array;

EOD;

        file_put_contents($fileName, $content);
        $this->stdout("Translation saved.\n", Console::FG_GREEN);
    }

    /**
     * Writes messages into PO file
     *
     * @param array $messages
     * @param string $dirName name of the directory to write to
     * @param boolean $overwrite if existing file should be overwritten without backup
     * @param boolean $removeUnused if obsolete translations should be removed
     * @param boolean $sort if translations should be sorted
     * @param string $catalog message catalog
     */
    protected function saveMessagesToPO($messages, $dirName, $overwrite, $removeUnused, $sort, $catalog)
    {
        $file = str_replace("\\", '/', "$dirName/$catalog.po");
        FileHelper::createDirectory(dirname($file));
        $this->stdout("Saving messages to $file...\n");

        $poFile = new GettextPoFile();

        $merged = [];
        $todos = [];

        $hasSomethingToWrite = false;
        foreach ($messages as $category => $msgs) {
            $notTranslatedYet = [];
            $msgs = array_values(array_unique($msgs));

            if (is_file($file)) {
                $existingMessages = $poFile->load($file, $category);

                sort($msgs);
                ksort($existingMessages);
                if (array_keys($existingMessages) == $msgs) {
                    $this->stdout("Nothing new in \"$category\" category...\n");

                    sort($msgs);
                    foreach ($msgs as $message) {
                        $merged[$category . chr(4) . $message] = $existingMessages[$message];
                    }
                    ksort($merged);
                    continue;
                }

                // merge existing message translations with new message translations
                foreach ($msgs as $message) {
                    if (array_key_exists($message, $existingMessages) && strlen($existingMessages[$message]) > 0) {
                        $merged[$category . chr(4) . $message] = $existingMessages[$message];
                    } else {
                        $notTranslatedYet[] = $message;
                    }
                }
                ksort($merged);
                sort($notTranslatedYet);

                // collect not yet translated messages
                foreach ($notTranslatedYet as $message) {
                    $todos[$category . chr(4) . $message] = '';
                }

                // add obsolete unused messages
                foreach ($existingMessages as $message => $translation) {
                    if (!isset($merged[$category . chr(4) . $message]) && !isset($todos[$category . chr(4) . $message]) && !$removeUnused) {
                        if (!empty($translation) && substr($translation, 0, 2) === '@@' && substr($translation, -2) === '@@') {
                            $todos[$category . chr(4) . $message] = $translation;
                        } else {
                            $todos[$category . chr(4) . $message] = '@@' . $translation . '@@';
                        }
                    }
                }

                $merged = array_merge($todos, $merged);
                if ($sort) {
                    ksort($merged);
                }

                if ($overwrite === false) {
                    $file .= '.merged';
                }
            } else {
                sort($msgs);
                foreach ($msgs as $message) {
                    $merged[$category . chr(4) . $message] = '';
                }
                ksort($merged);
            }
            $this->stdout("Category \"$category\" merged.\n");
            $hasSomethingToWrite = true;
        }
        if ($hasSomethingToWrite) {
            $poFile->save($file, $merged);
            $this->stdout("Translation saved.\n", Console::FG_GREEN);
        } else {
            $this->stdout("Nothing to save.\n", Console::FG_GREEN);
        }
    }

    /**
     * Prints a string to STDOUT
     *
     * You may optionally format the string with ANSI codes by
     * passing additional parameters using the constants defined in [[\yii\helpers\Console]].
     *
     * Example:
     *
     * ~~~
     * $this->stdout('This will be red and underlined.', Console::FG_RED, Console::UNDERLINE);
     * ~~~
     *
     * @param string $string the string to print
     * @return int|boolean Number of bytes printed or false on error
     */
    public function stdout($string)
    {
        if ($this->isColorEnabled()) {
            $args = func_get_args();
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
        }

        return Console::stdout($string);
    }

    /**
     * Returns a value indicating whether ANSI color is enabled.
     *
     * ANSI color is enabled only if [[color]] is set true or is not set
     * and the terminal supports ANSI color.
     *
     * @param resource $stream the stream to check.
     * @return boolean Whether to enable ANSI style in output.
     */
    public function isColorEnabled($stream = \STDOUT)
    {
        return $this->color === null ? Console::streamSupportsAnsiColors($stream) : $this->color;
    }
}
