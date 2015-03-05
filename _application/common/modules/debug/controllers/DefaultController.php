<?php

namespace common\modules\debug\controllers;

class DefaultController extends \yii\debug\controllers\DefaultController
{
    /**
     * @inheritdoc
     */
    public $layout = '@common/modules/debug/layouts/main.php';

    /**
     * Returns one-line short summary describing this controller.
     *
     * You may override this method to return customized summary.
     * The default implementation returns first line from the PHPDoc comment.
     *
     * @return string
     */
    public function getHelpSummary()
    {
        return $this->parseDocCommentSummary(new \ReflectionClass($this));
    }

    /**
     * Returns the first line of docblock.
     *
     * @param \Reflector $reflection
     * @return string
     */
    protected function parseDocCommentSummary($reflection)
    {
        $docLines = preg_split('~\R~u', $reflection->getDocComment());
        if (isset($docLines[1])) {
            return trim($docLines[1], "\t *");
        }
        return '';
    }
}
