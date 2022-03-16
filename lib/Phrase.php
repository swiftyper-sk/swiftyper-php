<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#intl">Swiftyper Internationalization API</a></strong>
 *
 * Prostredníctvom služby <strong>Swiftyper Internationalization API</strong> je možné vyhľadať
 * a uložiť frázy v anglickom jazyku do databázy aby sa dali preložiť. Ďalšie informácie o prekladoch nájdete
 * v časti <a href="https://developers.swiftyper.sk/docs/api#translations">Preklady</a>.
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#phrases_query">Vyhľadanie fráz</a></strong>
     *
     * Vyhľadanie natívnych fráz.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požiadavky
     *
     * @return \Swiftyper\Collection<Phrase> nájdené frázy
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#phrases_upload">Uloženie fráz</a></strong>
     *
     * Uloženie natívnych fráz.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požiadavky
     *
     * @return \Swiftyper\SwiftyperObject
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#phrases_raw">Načítanie fráz v FBT formáte</a></strong>
     *
     * Načítanie natívnych fráz v FBT formáte.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požiadavky
     *
     * @return \Swiftyper\SwiftyperObject
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
