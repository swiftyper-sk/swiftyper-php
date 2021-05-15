<?php

namespace Swiftyper;

/**
 * Class ApiRequestor.
 */
class ApiRequestor
{
    /**
     * @var null|string
     */
    private $_apiKey;

    /**
     * @var string
     */
    private $_apiBase;

    /**
     * @var HttpClient\ClientInterface
     */
    private static $_httpClient;

    private static $OPTIONS_KEYS = ['api_key', 'api_base'];

    /**
     * ApiRequestor constructor.
     *
     * @param null|string $apiKey
     * @param null|string $apiBase
     */
    public function __construct($apiKey = null, $apiBase = null)
    {
        $this->_apiKey = $apiKey;
        if (!$apiBase) {
            $apiBase = Swiftyper::$apiBase;
        }
        $this->_apiBase = $apiBase;
    }

    /**
     * @static
     *
     * @param ApiResource|array|bool|mixed $d
     *
     * @return ApiResource|array|mixed|string
     */
    private static function _encodeObjects($d)
    {
        if ($d instanceof ApiResource) {
            return Util\Util::utf8($d->id);
        }
        if (true === $d) {
            return 'true';
        }
        if (false === $d) {
            return 'false';
        }
        if (\is_array($d)) {
            $res = [];
            foreach ($d as $k => $v) {
                $res[$k] = self::_encodeObjects($v);
            }

            return $res;
        }

        return Util\Util::utf8($d);
    }

    /**
     * @param string     $method
     * @param string     $url
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws Exception\ApiErrorException
     *
     * @return array tuple containing (ApiReponse, API key)
     */
    public function request($method, $url, $params = null, $headers = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];
        list($rbody, $rcode, $rheaders, $myApiKey) =
        $this->_requestRaw($method, $url, $params, $headers);
        $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        $resp = new ApiResponse($rbody, $rcode, $rheaders, $json);

        return [$resp, $myApiKey];
    }

    /**
     * @param string $rbody a JSON string
     * @param int $rcode
     * @param array $rheaders
     * @param array $resp
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     */
    public function handleErrorResponse($rbody, $rcode, $rheaders, $resp)
    {
        if (!\is_array($resp) || !isset($resp['error'])) {
            $msg = "Invalid response object from API: {$rbody} "
              . "(HTTP response code was {$rcode})";

            throw new Exception\UnexpectedValueException($msg);
        }

        $errorData = $resp['error'];

        $error = null;
        if (!$error) {
            $error = self::_specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData);
        }

        throw $error;
    }

    /**
     * @static
     *
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     * @param array  $resp
     * @param array  $errorData
     *
     * @return Exception\ApiErrorException
     */
    private static function _specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData)
    {
        $msg = isset($errorData['message']) ? $errorData['message'] : null;
        $param = isset($errorData['param']) ? $errorData['param'] : null;
        $code = isset($errorData['code']) ? $errorData['code'] : null;

        switch ($rcode) {
            case 400:
                if ('over_query_limit' === $code) {
                    return Exception\QuotaException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

                if ('missing' === $code) {
                    return Exception\MissingException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
                }

                if ('restricted' === $code) {
                    return Exception\RestrictedException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
                }

                if ('unexpected_parameter' === $code) {
                    return Exception\UnexpectedParameterException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

                if ('invalid_request' === $code) {
                    return Exception\InvalidRequestException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

                if ('invalid_parameter' === $code) {
                    return Exception\InvalidParameterException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

                if ('missing_parameter' === $code) {
                    return Exception\MissingParameterException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

                if ('invalid_api_key' === $code) {
                    return Exception\InvalidApiKeyException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

                if ('rate_limit' === $code) {
                    return Exception\RateLimitException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);
                }

            case 404:
                return Exception\InvalidRequestException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);

            default:
                return Exception\UnknownApiErrorException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
        }
    }

    /**
     * @static
     *
     * @param string $disabledFunctionsOutput - String value of the 'disable_function' setting, as output by \ini_get('disable_functions')
     * @param string $functionName - Name of the function we are interesting in seeing whether or not it is disabled
     * @param mixed $disableFunctionsOutput
     *
     * @return bool
     */
    private static function _isDisabled($disableFunctionsOutput, $functionName)
    {
        $disabledFunctions = \explode(',', $disableFunctionsOutput);
        foreach ($disabledFunctions as $disabledFunction) {
            if (\trim($disabledFunction) === $functionName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @static
     *
     * @param string $apiKey
     * @param null   $clientInfo
     *
     * @return array
     */
    private static function _defaultHeaders($apiKey, $clientInfo = null)
    {
        $uaString = 'Swiftyper/v1 PhpBindings/' . Swiftyper::VERSION;

        $langVersion = \PHP_VERSION;
        $uname_disabled = static::_isDisabled(\ini_get('disable_functions'), 'php_uname');
        $uname = $uname_disabled ? '(disabled)' : \php_uname();

        $ua = [
            'bindings_version' => Swiftyper::VERSION,
            'lang' => 'php',
            'lang_version' => $langVersion,
            'publisher' => 'swiftyper',
            'uname' => $uname,
        ];
        if ($clientInfo) {
            $ua = \array_merge($clientInfo, $ua);
        }

        return [
            'X-Swiftyper-Client-User-Agent' => \json_encode($ua),
            'User-Agent' => $uaString,
            'X-Swiftyper-Api-Key' => $apiKey,
        ];
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     *
     * @throws Exception\InvalidApiKeyException
     * @throws Exception\ApiConnectionException
     *
     * @return array
     */
    private function _requestRaw($method, $url, $params, $headers)
    {
        $myApiKey = $this->_apiKey;
        if (!$myApiKey) {
            $myApiKey = Swiftyper::$apiKey;
        }

        if (!$myApiKey) {
            $msg = 'No API key provided.  (HINT: set your API key using '
              . '"Swiftyper::setApiKey(<API-KEY>)".  You can generate API keys from '
              . 'the Swiftyper web interface.  See https://manage.swiftyper.sk/ for '
              . 'details, or email podpora@swiftyper.sk if you have any questions.';

            throw new Exception\InvalidApiKeyException($msg);
        }

        // Clients can supply arbitrary additional keys to be included in the
        // X-Swiftyper-Client-User-Agent header via the optional getUserAgentInfo()
        // method
        $clientUAInfo = null;
        if (\method_exists($this->httpClient(), 'getUserAgentInfo')) {
            $clientUAInfo = $this->httpClient()->getUserAgentInfo();
        }

        if ($params && \is_array($params)) {
            $optionKeysInParams = \array_filter(
                static::$OPTIONS_KEYS,
                function ($key) use ($params) {
                    return \array_key_exists($key, $params);
                }
            );
            if (\count($optionKeysInParams) > 0) {
                $message = \sprintf('Options found in $params: %s. Options should '
                  . 'be passed in their own array after $params. (HINT: pass an '
                  . 'empty array to $params if you do not have any.)', \implode(', ', $optionKeysInParams));
                \trigger_error($message, \E_USER_WARNING);
            }
        }

        $absUrl = $this->_apiBase . $url;
        $params = self::_encodeObjects($params);
        $defaultHeaders = $this->_defaultHeaders($myApiKey, $clientUAInfo);

        $defaultHeaders['Content-Type'] = 'application/x-www-form-urlencoded';

        $combinedHeaders = \array_merge($defaultHeaders, $headers);
        $rawHeaders = [];

        foreach ($combinedHeaders as $header => $value) {
            $rawHeaders[] = $header . ': ' . $value;
        }

        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $absUrl,
            $rawHeaders,
            $params,
            false
        );

        return [$rbody, $rcode, $rheaders, $myApiKey];
    }

    /**
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     *
     * @return array
     */
    private function _interpretResponse($rbody, $rcode, $rheaders)
    {
        $resp = \json_decode($rbody, true);
        $jsonError = \json_last_error();
        if (null === $resp && \JSON_ERROR_NONE !== $jsonError) {
            $msg = "Invalid response body from API: {$rbody} "
              . "(HTTP response code was {$rcode}, json_last_error() was {$jsonError})";

            throw new Exception\UnexpectedValueException($msg, $rcode);
        }

        if ($rcode < 200 || $rcode >= 300) {
            $this->handleErrorResponse($rbody, $rcode, $rheaders, $resp);
        }

        return $resp;
    }

    /**
     * @static
     *
     * @param HttpClient\ClientInterface $client
     */
    public static function setHttpClient($client)
    {
        self::$_httpClient = $client;
    }

    /**
     * @return HttpClient\ClientInterface
     */
    private function httpClient()
    {
        if (!self::$_httpClient) {
            self::$_httpClient = HttpClient\CurlClient::instance();
        }

        return self::$_httpClient;
    }
}
