<?php

/**
 * @see http://www.yiiframework.com/forum/index.php/topic/56027-yii2-multilingual-website-url-rules/
 * @see https://github.com/phemellc/yii2-i18n-url
 */
namespace common\components\widgets;

use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use Yii;

class LanguageSwitcher extends ButtonDropdown
{
    private static $_labels;

    public $beginTag = '';
    public $endTag   = '';

    /**
     * Renders the language drop down if there are currently more than one languages in the app.
     * If you pass an associative array of language names along with their code to the URL manager
     * those language names will be displayed in the drop down instead of their codes.
     */
    public function run()
    {
        if (count(Yii::$app->i18n->languages) > 1) {
            $appLanguage = Yii::$app->language;
            $items = [];
            foreach (Yii::$app->i18n->languages as $lang) {
                if ($lang === $appLanguage) {
                    $this->label = static::label($lang);
                }
                $label = static::label($lang);
                if ( empty($label) ) {
                    continue;
                }

                $item = [
                    'label' => static::label($lang),
                    'url'   => $this->getUrl($lang),
                ];
                $items[] = $item;
            }

            $this->dropdown['items'] = $items;

            echo $this->getBeginTag() . parent::run() . $this->getEndTag();
        }
    }

    /**
     * Menu Items for Navbar list
     * @return array
     */
    public static function getMenuItems()
    {
        $output = [];                                                           // default

        if (count(Yii::$app->i18n->languages) > 1) {
            $self = new self();
            $appLanguage = Yii::$app->language;
            $items = [];
            foreach (Yii::$app->i18n->languages as $lang) {
                $label = static::label($lang);
                if ( empty($label) ) {
                    continue;
                }
                if ($lang === $appLanguage) {
                    $self->label = $label;
                }

                $item = [
                    'label' => static::label($lang),
                    'url'   => $self->getUrl($lang),
                ];
                $items[] = $item;
            }

            $output['label'] = $self->label;
            $output['url']   = $self->getUrl($appLanguage);
            $output['items'] = $items;
        }

        return $output;
    }

    public function getBeginTag()
    {
        if ( isset($this->options['beginTag']) ) {
            $this->beginTag = $this->options['beginTag'];
        }

        return $this->beginTag;
    }

    public function getEndTag()
    {
        if ( isset($this->options['endTag']) ) {
            $this->endTag = $this->options['endTag'];
        }

        return $this->endTag;
    }

    /**
     * @param string $lang
     * @return string
     */
    private function getUrl($lang = '')
    {
        $route  = Yii::$app->controller->route;
        $output = Yii::getAlias('@web') . (!empty($lang) ? '/' . $lang : '') . $this->filter($route);

        return $output;
    }

    /**
     * @param string $route
     * @return string
     */
    private function filter($route = '')
    {
        $urls        = [];
        $request     = Yii::$app->getRequest();
        $baseUrl     = $request->baseUrl;
        $queryParams = $request->queryParams;

        foreach (Yii::$app->i18n->languages as $lang) {
            $urls[] = trim($baseUrl . '/' . $lang, "\\/");
        }

        $route = '/' . ltrim(preg_replace("#i18n/default/(index|update)#i", 'translations', $route), "\\/");

        array_unshift($queryParams, $route);

        $route = Url::to($queryParams);

        // filter langs from route
        $pattern1 = '#^/(' . implode('|', $urls) . ')/#i';
        $pattern2 = '#^/(' . implode('|', $urls) . ')$#i';
        $route    = preg_replace(array($pattern1, $pattern2), '/', $route, 1);

        return $route;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function label($code)
    {
        if (self::$_labels === null) {
            self::$_labels = [
                'en' => 'English',
                'fr' => 'Français',
                'it' => 'Italiano',
                'es' => 'Español',
                'pt' => 'Português',
                'ru' => 'Русский',
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }
}
