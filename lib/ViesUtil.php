<?php

namespace Swiftyper;

use Swiftyper\Exception\ApiErrorException;

class ViesUtil extends ApiResource
{
    const OBJECT_NAME = 'vies';

    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/utils/vies';
    }

    /**
     * Validate VAT number.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @return SwiftyperObject
     * @throws ApiErrorException if the request fails
     */
    public static function checkVatNumber($params = null, $opts = null)
    {
        $url = static::classUrl() . '/check-vat-number';
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
