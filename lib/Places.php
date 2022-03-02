<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#places">Swiftyper Places API</a></strong>
 *
 * Prostredníctvom služby <strong>Swiftyper Places API</strong> je možné vyhľadať viacero druhov miest - adresu, ulicu, obec a poštové smerovacie číslo.
 *
 * @property string          $place_id Unikátny identifikátor miesta
 * @property string          $highlight Zvýraznená časť zhodná s dopytom vyhľadávania
 * @property null|string     $formatted_address Naformátovaná adresa miesta
 * @property null|string     $street Názov ulice
 * @property null|string     $formatted_street Naformátovaná ulica
 * @property null|string     $street_number Súpisné číslo
 * @property null|string     $building_number Orientačné číslo
 * @property null|string     $formatted_number Naformátované číslo ulice
 * @property null|string     $postal_code Poštové smerovacie číslo
 * @property string          $municipality Názov obce
 * @property string          $county Názov okresu
 * @property string          $region Názov kraju
 * @property SwiftyperObject $latlng Geokódovaná zemepisná šírka a dĺžka
 * @property string          $object Typ objektu, môže byť 'address', 'street', 'municipality', 'postal_code'
 * @property string          $formatted_country Názov krajiny
 * @property string          $country Kód krajiny (dvojmiestny alfabetický kód ISO 3166)
 */
class Places extends ApiResource
{
    const OBJECT_NAME = 'places';

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_query">Vyhľadanie adresy</a></strong>
     *
     * Vyhľadanie poštových adries cez akúkoľvek časť adresy
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Address> nájdené adresy
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function query($params = null, $opts = null)
    {
        $url = static::classUrl().'/query';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_region_codes">Číselník krajov</a></strong>
     *
     * Zobrazenie základného zoznamu obsahujúceho kraje konkrétnej krajiny.
     * Zobrazenie číselníku sa nepočíta do mesačého limitu.
     *
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> zoznam krajov
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function regions($opts = null)
    {
        $url = static::classUrl().'/regions';
        list($response, $opts) = static::_staticRequest('post', $url, [], $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_county_codes">Číselník okresov</a></strong>
     *
     * Zobrazenie základného zoznamu obsahujúceho okresy konkrétnej krajiny.
     * Zobrazenie číselníku sa nepočíta do mesačého limitu.
     *
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> zoznam okresov
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function counties($opts = null)
    {
        $url = static::classUrl().'/counties';
        list($response, $opts) = static::_staticRequest('post', $url, [], $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_street">Vyhľadanie ulice</a></strong>
     *
     * Vyhľadanie ulíc na základe názvu
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Street> nájdené ulice
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function street($params = null, $opts = null)
    {
        $url = static::classUrl().'/street';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_municipality">Vyhľadanie obce</a></strong>
     *
     * Vyhľadanie obcí na základe názvu
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Municipality> nájdené obce
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function municipality($params = null, $opts = null)
    {
        $url = static::classUrl().'/municipality';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_postal">Vyhľadanie PSČ</a></strong>
     *
     * Vyhľadanie poštového smerovacieho čísla na základe kódu
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\PostalCode> nájdené psč
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function postal($params = null, $opts = null)
    {
        $url = static::classUrl().'/postal';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_detail">Detail miesta</a></strong>
     *
     * Načítanie podrobností na základe identifikátora miesta.
     * Prostredníctvom identifikátora je možné načítať adresu,
     * ulicu, obec a poštové smerovacie čísla.
     *
     * @param string                                $place_id
     * @param null|array|Util\RequestOptions|string $opts
     *
     * @return \Swiftyper\Address|\Swiftyper\Street|\Swiftyper\Municipality|\Swiftyper\PostalCode nájdené miesto
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function detail($place_id, $opts = null)
    {
        $opts = Util\RequestOptions::parse($opts);
        $instance = new static($place_id, $opts);
        $instance->refresh();

        return $instance;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_reverse_geocoding">Reverzné geokódovanie</a></strong>
     *
     * Vyhľadávanie adresy podľa zemepisných súradníc (GPS, systém <a href="https://sk.wikipedia.org/wiki/Svetov%C3%BD_geodetick%C3%BD_syst%C3%A9m_1984">WGS84</a>).
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Address> nájdené miesta
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function reverse($params = null, $opts = null)
    {
        $url = static::classUrl().'/reverse';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_validation">Overenie adresy</a></strong>
     *
     * Overenie adresy
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> výsledok validácie
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požidavky
     *
     */
    public static function validate($params = null, $opts = null)
    {
        $url = static::classUrl().'/validate';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
