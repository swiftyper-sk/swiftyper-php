<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#business">Swiftyper Business API</a></strong>
 *
 * Prostredníctvom služby <strong>Swiftyper Business API</strong> je možné vyhľadať
 * právnicke osoby a SZČO viacerými spôsobmi - prostredníctvom identifikačného čísla
 * organizácie a na základe názvu právnickej osoby prípadne SZČO.
 *
 * @property string $business_id Unikátny identifikátor subjektu
 * @property string $highlight Zvýraznená časť zhodná s dopytom vyhľadávania
 * @property string $name Názov subjektu
 * @property string $established_on Dátum vzniku
 * @property string $terminated_on Dátum zániku
 * @property string $cin Identifikačné číslo organizácie (IČO)
 * @property string $tin Daňové identifikačné číslo (DIČ)
 * @property string $vatin Identifikačné číslo pre daň z pridanej hodnoty (IČ DPH)
 * @property string $formatted_address Naformátovaná adresa
 * @property string $street Názov ulice
 * @property string $formatted_street Naformátovaná ulica
 * @property string $street_number Súpisné číslo
 * @property string $building_number Orientačné číslo
 * @property string $formatted_number Naformátované číslo ulice
 * @property string $postal_code PSČ
 * @property string $municipality Názov obce
 * @property string $legal_form Názov právnej formy
 * @property string $object Typ objektu, môže byť 'business'
 * @property string $formatted_country Názov krajiny
 * @property string $country Kód krajiny (dvojmiestny alfabetický kód ISO 3166)
 */
class Business extends ApiResource
{
    const OBJECT_NAME = 'business';

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#business_query">Vyhľadanie subjektu</a></strong>
     *
     * Vyhľadanie kontaktných a fakturačných údajov o právnických osobách
     * a SZČO na základe názvu právnickej osoby prípadne SZČO.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požiadavky
     *
     * @return \Swiftyper\Collection<Business> nájdené subjekty
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#business_identifier">Vyhľadanie podľa IČO</a></strong>
     *
     * Vyhľadanie kontaktných a fakturačných údajov o právnických osobách
     * a SZČO na základe identifikačného čísla organizácie.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požiadavky
     *
     * @return \Swiftyper\Business nájdený subjekt
     */
    public static function identifier($params = null, $opts = null)
    {
        $url = static::classUrl() . '/identifier';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#business_detail">Detail subjektu</a></strong>
     *
     * Načítanie podrobností právnickej osoby a SZČO na základe identifikátora subjektu.
     *
     * @param string $business_id
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException v prípade zlyhania požiadavky
     *
     * @return \Swiftyper\Business nájdený subjekt
     */
    public static function detail($business_id, $opts = null)
    {
        $url = static::classUrl() . '/identifier';
        list($response, $opts) = static::_staticRequest('post', $url, compact('business_id'), $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
