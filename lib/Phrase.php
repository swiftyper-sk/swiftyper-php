<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#intl">Swiftyper Internationalization API</a></strong>
 *
 * Through the <strong>Swiftyper Internationalization API</strong> service,
 * it is possible to search for and save phrases in English into the database, so they can be translated. You can find more information about translations
 * in the <a href="https://developers.swiftyper.sk/docs/api#translations">Translations</a>.
 *
 * @property int $id
 * @property int $parent_id
 * @property string $object
 * @property array $source
 * @property string $hash
 * @property string $text
 * @property string $description
 * @property string $author
 * @property string $project
 * @property string $created_at
 */
class Phrase extends ApiResource
{
    const OBJECT_NAME = 'phrase';

    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/intl/phrases';
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#phrases_query">Searching for native phrases</a></strong>
     *
     * Searching for native phrases.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\Collection<Phrase> found phrases
     */
    public static function query($params = null, $opts = null)
    {
        $url = static::classUrl() . '/query';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#phrases_upload">Saving native phrases</a></strong>
     *
     * Saving native phrases.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject upload results
     */
    public static function upload($params = null, $opts = null)
    {
        $url = static::classUrl() . '/upload';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#phrases_raw">Loading native phrases in FBT format</a></strong>
     *
     * Loading native phrases in FBT format.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject raw phrases
     */
    public static function raw($params = null, $opts = null)
    {
        $url = static::classUrl() . '/raw';
        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
