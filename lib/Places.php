<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/docs/api#places">Swiftyper Places API</a></strong>
 *
 * Through the <strong>Swiftyper Places API</strong> service, it is possible to search for several types of places - address, street, municipality, and postal code.
 *
 * @property string          $place_id Unique identifier of the place
 * @property string          $highlight Highlighted part matching the search query
 * @property null|string     $formatted_address Formatted address of the place
 * @property null|string     $street Street name
 * @property null|string     $formatted_street Formatted street
 * @property null|string     $street_number Conscription number
 * @property null|string     $building_number Orientation number
 * @property null|string     $formatted_number Formatted street number
 * @property null|string     $postal_code Postal code
 * @property string          $municipality Municipality name
 * @property string          $county County name
 * @property string          $region Region name
 * @property SwiftyperObject $latlng Geocoded latitude and longitude
 * @property string          $object Type of object, can be 'address', 'street', 'municipality', 'postal_code'
 * @property string          $formatted_country Country name
 * @property string          $country Country code (two-letter ISO 3166 code)
 */
class Places extends ApiResource
{
    const OBJECT_NAME = 'places';

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_query">Searching for an address</a></strong>
     *
     * Searching for postal addresses through any part of the address.
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Address> found addresses
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_region_codes">List of regions</a></strong>
     *
     * Displaying a basic list containing the regions of a specific country.
     * Displaying the code list does not count towards the monthly limit.
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> list of regions
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     */
    public static function regions($params = null, $opts = null)
    {
        $url = static::classUrl().'/regions';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_county_codes">List of counties</a></strong>
     *
     * Displaying a basic list containing the counties of a specific country.
     * Displaying the code list does not count towards the monthly limit.
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> list of counties
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     */
    public static function counties($params = null, $opts = null)
    {
        $url = static::classUrl().'/counties';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_municipalities_codes">List of municipalities</a></strong>
     *
     * Displaying a basic list containing the municipalities of a specific country.
     * Displaying the code list does not count towards the monthly limit.
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> list of municipalities
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     */
    public static function municipalities($params = null, $opts = null)
    {
        $url = static::classUrl().'/municipalities';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_street">Searching for a street</a></strong>
     *
     * Searching for streets based on the name
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Street> found streets
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_municipality">Searching for a municipality</a></strong>
     *
     * Searching for municipalities based on the name
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Municipality> found municipalities
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_postal">Searching for a postal code</a></strong>
     *
     * Searching for a postal code based on the code
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\PostalCode> found postal codes
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_detail">Details of the place</a></strong>
     *
     * Loading details based on the place identifier.
     * Through the identifier, it is possible to load an address,
     * street, municipality, and postal code.
     *
     * @param string                                $place_id
     * @param null|array|Util\RequestOptions|string $opts
     *
     * @return \Swiftyper\Address|\Swiftyper\Street|\Swiftyper\Municipality|\Swiftyper\PostalCode found place/address/street/municipality/postal code
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_reverse_geocoding">Reverse geocoding</a></strong>
     *
     * Searching for an address based on geographical coordinates (GPS, system <a href="https://sk.wikipedia.org/wiki/Svetov%C3%BD_geodetick%C3%BD_syst%C3%A9m_1984">WGS84</a>).
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\Address> found addresses
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
     * <strong><a href="https://developers.swiftyper.sk/docs/api#place_validation">Address validation</a></strong>
     *
     * Address validation.
     *
     * @param null|array        $params
     * @param null|array|string $opts
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> validation result
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
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
