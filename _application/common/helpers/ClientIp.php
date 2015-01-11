<?php

namespace common\helpers;

class ClientIp
{
    /**
     * @return string
     */
    public static function get()
    {
        $output = '';                                                           // default

        // @see http://en.wikipedia.org/wiki/X-Forwarded-For
        if ( isset($_SERVER[self::normalizeProxyHeader('X-Forwarded-For')]) )
            $output = $_SERVER[self::normalizeProxyHeader('X-Forwarded-For')];
        else if ( isset($_SERVER[self::normalizeProxyHeader('X-Real-IP')]) )
            $output = $_SERVER[self::normalizeProxyHeader('X-Real-IP')];

        if ( isset($_SERVER['REMOTE_ADDR']) )
            $output = $_SERVER['REMOTE_ADDR'];

        return $output;
    }

    /**
     * @see https://github.com/zendframework/zf2/blob/master/library/Zend/Http/PhpEnvironment/RemoteAddress.php#L163
     *
     * Normalize a header string
     *
     * Normalizes a header string to a format that is compatible with
     * $_SERVER
     *
     * @param  string $header
     * @return string
     */
    public static function normalizeProxyHeader($header)
    {
        $header = strtoupper($header);
        $header = str_replace('-', '_', $header);
        if (0 !== strpos($header, 'HTTP_')) {
            $header = 'HTTP_' . $header;
        }

        return $header;
    }
}
