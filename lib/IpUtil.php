<?php

namespace Swiftyper;

use Swiftyper\Exception\ApiErrorException;

class IpUtil extends ApiResource
{
    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/utils/ip';
    }

    /**
     * Get IP information.
     *
     * @param string $ip
     * @param null|array|string $opts
     *
     * @return SwiftyperObject IP information
     * @throws ApiErrorException if the request fails
     */
    public static function info($ip, $opts = null)
    {
        $url = static::classUrl() . '/' . $ip;
        list($response, $opts) = static::_staticRequest('get', $url, [], $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
