<?php

namespace Swiftyper;

use Swiftyper\Exception\ApiErrorException;

class ImageUtil extends ApiResource
{
    /**
     * @return string The class URL for this resource. It needs to be special
     *    cased because it doesn't fit into the standard resource pattern.
     */
    public static function classUrl()
    {
        return '/v1/utils/image';
    }

    /**
     * Image optimization.
     *
     * @param string $filename
     * @param null|array|string $opts
     *
     * @return SwiftyperObject
     * @throws ApiErrorException if the request fails
     */
    public static function optimize($filename, $opts = null)
    {
        $url = static::classUrl() . '/optimize';
        list($response, $opts) = static::_staticRequest('post', $url, [
            'image' => \curl_file_create($filename),
        ], $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
