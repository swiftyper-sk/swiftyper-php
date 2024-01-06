<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#business">Swiftyper Business API</a></strong>
 *
 * Through the <strong>Swiftyper Business API</strong> service, it is possible to search
 * for legal entities and self-employed individuals in several ways - through the identification number
 * of the organization and based on the name of the legal entity or self-employed individual.
 *
 * @property string $business_id Unique identifier of the subject
 * @property string $highlight Highlighted part matching the search query
 * @property string $name Name of the subject
 * @property string $established_on Date of establishment
 * @property string $terminated_on Date of termination
 * @property string $cin Identification number of the organization (CIN)
 * @property string $tin Tax identification number (TIN)
 * @property string $vatin Identification number for value added tax (VATIN)
 * @property string $formatted_address Formatted address
 * @property string $street Street name
 * @property string $formatted_street Formatted street
 * @property string $street_number Conscription number
 * @property string $building_number Orientation number
 * @property string $formatted_number Formatted street number
 * @property string $postal_code Postal code
 * @property string $municipality Name of the municipality
 * @property string $legal_form Name of the legal form
 * @property string $object Type of object, can be 'business'
 * @property string $formatted_country Country name
 * @property string $country Country code (two-letter ISO 3166 code)
 */
class Business extends ApiResource
{
    const OBJECT_NAME = 'business';

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#business_query">Searching for a business record</a></strong>
     *
     * Searching for contact and billing information about legal entities and self-employed individuals
     * based on the name of the legal entity or self-employed individual.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\Collection<Business> found business records
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#business_identifier">Searching by CIN</a></strong>
     *
     * Searching for contact and billing information about legal entities and self-employed individuals
     * based on the identification number of the organization.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\Business found business record
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#business_detail">Business record details</a></strong>
     *
     * Loading details of a legal entity and self-employed individual based on the subject identifier.
     *
     * @param string $business_id
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\Business found business record
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
