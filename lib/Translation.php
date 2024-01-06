<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#intl">Swiftyper Internationalization API</a></strong>
 *
 * Prostredníctvom služby <strong>Swiftyper Internationalization API</strong> je možné vyhľadať a preložiť
 * uložené natívne frázy vašej aplikácie.
 *
 * @property int $id
 * @property int $phrase_id
 * @property string $object
 * @property string $phrase_hash
 * @property string $hash
 * @property array $translation
 * @property string $approval_status
 * @property array $variations
 * @property array $tokens
 * @property array $types
 * @property string $locale
 * @property string $created_at
 */
class Translation extends ApiResource
{
    const OBJECT_NAME = 'translation';

    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/intl/translations';
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#translations_query">Vyhľadanie prekladov</a></strong>
     *
     * Vyhľadanie a načítanie prekladov. Pokiaľ použijete parameter 'reviewed', výstupom budú iba preklady ktoré
     * boli schválené automaticky (podľa počtu hlasov), alebo manuálne.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\Collection<Translation> nájdené preklady
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#translating">Uloženie prekladu</a></strong>
     *
     * Uloženie prekladu frázy do vybraného jazyka.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject
     */
    public static function translate($params = null, $opts = null)
    {
        $url = static::classUrl() . '/submit';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#translations_upload">Uloženie prekladov</a></strong>
     *
     * Hromadné ukladanie prekladov.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * Načítanie prekladov v FBT formáte.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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

    /**
     * Vygenerovanie variantov prekladu pokiaľ závisí napr. od počtu, pohlavia subjektu alebo prezerajúceho používateľa.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject
     */
    public static function variationGrid($params = null, $opts = null)
    {
        $url = static::classUrl() . '/variationgrid';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
