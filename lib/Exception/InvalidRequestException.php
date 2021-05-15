<?php

namespace Swiftyper\Exception;

/**
 * InvalidRequestException is thrown when a request is initiated with invalid
 * parameters.
 */
class InvalidRequestException extends ApiErrorException
{
    protected $swiftyperParam;

    /**
     * Creates a new InvalidRequestException exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|\Swiftyper\Util\CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $swiftyperCode the Swiftyper error code
     * @param null|string $swiftyperParam the parameter related to the error
     *
     * @return InvalidRequestException
     */
    public static function factory(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null,
        $swiftyperCode = null,
        $swiftyperParam = null
    ) {
        $instance = parent::factory($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders, $swiftyperCode);
        $instance->setSwiftyperParam($swiftyperParam);

        return $instance;
    }

    /**
     * Gets the parameter related to the error.
     *
     * @return null|string
     */
    public function getSwiftyperParam()
    {
        return $this->swiftyperParam;
    }

    /**
     * Sets the parameter related to the error.
     *
     * @param null|string $swiftyperParam
     */
    public function setSwiftyperParam($swiftyperParam)
    {
        $this->swiftyperParam = $swiftyperParam;
    }
}
