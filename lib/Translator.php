<?php

namespace Swiftyper;

use Swiftyper\Exception\ApiErrorException;

class Translator extends ApiResource
{
    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/intl/translator';
    }

    /**
     * Prekladanie textu.
     *
     * @param string $query
     * @param string $targetLanguage
     * @param string $sourceLanguage
     * @return SwiftyperObject
     * @throws ApiErrorException v prípade zlyhania požiadavky
     */
    public static function translate($query, $targetLanguage, $sourceLanguage = 'auto', $opts = null)
    {
        $url = static::classUrl() . '/translate';
        list($response, $opts) = static::_staticRequest('post', $url, [
            'q' => $query,
            'sl' => $sourceLanguage,
            'tl' => $targetLanguage,
        ], $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
