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
        $route          = Yii::$app->controller->route;
        $appLanguage    = Yii::$app->language;
        $params         = $_GET;

        array_unshift($params, $route);

        $languages  = isset(Yii::$app->localeUrls->languages)
                    ? Yii::$app->localeUrls->languages
                    : [];

        if (count($languages) > 1) {
            $items = [];
            foreach ($languages as $lang) {
                if ($lang === $appLanguage) {
                    $this->label = static::label($lang);
                }

                $item = [
                    'label' => static::label($lang),
                    'url'   => $this->getUrl($lang, $params[0]),
                ];
                $items[] = $item;
            }

            $this->dropdown['items'] = $items;

            parent::run();
        }
    }

    /**
     * @param string $lang
     * @param string $requestUri
     * @return string
     */
    private function getUrl($lang = '', $requestUri = null)
    {
        $output = Yii::getAlias('@web') . (!empty($lang) ? '/' . $lang : '') . $this->filter($requestUri);

//        // debug info ----------------------------------------------------------
//        \common\components\log\AppLogger::info(array(
//            '$lang'         => $lang,
//            '$requestUri'   => $requestUri,
//            '$output'       => $output,
//        ));
//        // ---------------------------------------------------------------------

        return $output;
    }

    /**
     * @param string $requestUri
     * @return string
     */
    private function filter($requestUri = '')
    {
        $params     = Yii::$app->params;
        $languages  = isset($params['app.localeUrls'], $params['app.localeUrls']['languages'])
                    ? $params['app.localeUrls']['languages'] : [];
        $urls       = [];
        $webRoot    = Yii::getAlias('@web');

        foreach ($languages as $lang) {
            $urls[] = trim($webRoot . '/' . $lang, "/\\");
        }

        $requestUri = '/' . ltrim(preg_replace("#i18n/default/(index|update)#i", 'translations', $requestUri), "/\\");
        $requestUri = Url::to([$requestUri]);

        // filter langs
        $pattern    = '#^/' . implode('|', $urls) . '/#i';
        $requestUri = preg_replace($pattern, '', $requestUri);

//        // debug info ----------------------------------------------------------
//        \common\components\log\AppLogger::info(array(
//            '$languages'    => $languages,
//            '$urls'         => $urls,
//            '$pattern'      => $pattern,
//            '$requestUri'   => $requestUri,
//            '$requestUri'   => $requestUri,
//        ));
//        // ---------------------------------------------------------------------

        return $requestUri;
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
                'en' => Yii::t('app-language', 'English'),
                'ru' => Yii::t('app-language', 'Russian'),
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }
}
