<?php

namespace Swiftyper;

class Fbt extends ApiResource
{
    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/intl/fbt';
    }

    /**
     * <strong>Initialize FBT project</strong>
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject
     */
    public static function initialize($params = null, $opts = null)
    {
        $url = static::classUrl() . '/initialize';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
