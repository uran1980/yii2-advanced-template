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

//        // debug info ----------------------------------------------------------
//        \common\components\log\AppLogger::info(array(
//            '$lang'   => $lang,
//            '$route'  => $route,
//            '$output' => $output,
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
        $params      = Yii::$app->params;
        $languages   = isset($params['app.localeUrls'], $params['app.localeUrls']['languages'])
                     ? $params['app.localeUrls']['languages'] : [];
        $urls        = [];
        $request     = Yii::$app->getRequest();
        $baseUrl     = $request->baseUrl;
        $queryParams = $request->queryParams;

        foreach ($languages as $lang) {
            $urls[] = trim($baseUrl . '/' . $lang, "/\\");
        }

        $requestUri = '/' . ltrim(preg_replace("#i18n/default/(index|update)#i", 'translations', $requestUri), "/\\");

        array_unshift($queryParams, $requestUri);

        $requestUri = Url::to($queryParams);

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
//            'route'         => Yii::$app->controller->route,
//            'baseUrl'       => $request->baseUrl,
//            'queryParams'   => $queryParams,
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
                'en' => Yii::t('common', 'English'),
                'ru' => Yii::t('common', 'Russian'),
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }
}
