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

    /**
     * Renders the language drop down if there are currently more than one languages in the app.
     * If you pass an associative array of language names along with their code to the URL manager
     * those language names will be displayed in the drop down instead of their codes.
     */
    public function run()
    {
        $appLanguage = Yii::$app->language;
        if (count(Yii::$app->i18n->languages) > 1) {
            $items = [];
            foreach (Yii::$app->i18n->languages as $lang) {
                if ($lang === $appLanguage) {
                    $this->label = static::label($lang);
                }

                $item = [
                    'label' => static::label($lang),
                    'url'   => $this->getUrl($lang),
                ];
                $items[] = $item;
            }

            $this->dropdown['items'] = $items;

            echo parent::run();
        }
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
            $urls[] = trim($baseUrl . '/' . $lang, "/\\");
        }

        $route = '/' . ltrim(preg_replace("#i18n/default/(index|update)#i", 'translations', $route), "/\\");

        array_unshift($queryParams, $route);

        $route = Url::to($queryParams);

        // filter langs
        $pattern = '#^/' . implode('|', $urls) . '/#i';
        $route   = preg_replace($pattern, '', $route);

        return $route;
    }

    /**
     *
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
