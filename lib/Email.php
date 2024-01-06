<?php

namespace Swiftyper;

use Swiftyper\Exception\ApiErrorException;

class Email extends ApiResource
{
    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/utils/email';
    }

    /**
     * Validate email address.
     *
     * @param string $email
     * @param null|array|string $opts
     *
     * @return SwiftyperObject validation result
     * @throws ApiErrorException if the request fails
     */
    public static function validate($email, $opts = null)
    {
        $url = static::classUrl() . '/validate';
        list($response, $opts) = static::_staticRequest('post', $url, [
            'email' => $email,
        ], $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
