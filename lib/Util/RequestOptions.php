<?php

namespace Swiftyper\Util;

class RequestOptions
{
    /**
     * @var array<string> a list of headers that should be persisted across requests
     */
    public static $HEADERS_TO_PERSIST = [
        'Swiftyper-Account',
        'Swiftyper-Version',
    ];

    /** @var array<string, string> */
    public $headers;

    /** @var null|string */
    public $apiKey;

    /** @var null|string */
    public $apiBase;

    /**
     * @param null|string $key
     * @param array<string, string> $headers
     * @param null|string $base
     */
    public function __construct($key = null, $headers = [], $base = null)
    {
        $this->apiKey = $key;
        $this->headers = $headers;
        $this->apiBase = $base;
    }

    /**
     * @return array<string, string>
     */
    public function __debugInfo()
    {
        return [
            'apiKey' => $this->redactedApiKey(),
            'headers' => $this->headers,
            'apiBase' => $this->apiBase,
        ];
    }

    /**
     * Unpacks an options array and merges it into the existing RequestOptions
     * object.
     *
     * @param null|array|RequestOptions|string $options a key => value array
     * @param bool $strict when true, forbid string form and arbitrary keys in array form
     *
     * @return RequestOptions
     */
    public function merge($options, $strict = false)
    {
        $other_options = self::parse($options, $strict);
        if (null === $other_options->apiKey) {
            $other_options->apiKey = $this->apiKey;
        }
        if (null === $other_options->apiBase) {
            $other_options->apiBase = $this->apiBase;
        }
        $other_options->headers = \array_merge($this->headers, $other_options->headers);

        return $other_options;
    }

    /**
     * Discards all headers that we don't want to persist across requests.
     */
    public function discardNonPersistentHeaders()
    {
        foreach ($this->headers as $k => $v) {
            if (!\in_array($k, self::$HEADERS_TO_PERSIST, true)) {
                unset($this->headers[$k]);
            }
        }
    }

    /**
     * Unpacks an options array into an RequestOptions object.
     *
     * @param null|array|RequestOptions|string $options a key => value array
     * @param bool $strict when true, forbid string form and arbitrary keys in array form
     *
     * @throws \Swiftyper\Exception\InvalidArgumentException
     *
     * @return RequestOptions
     */
    public static function parse($options, $strict = false)
    {
        if ($options instanceof self) {
            return $options;
        }

        if (null === $options) {
            return new RequestOptions(null, [], null);
        }

        if (\is_string($options)) {
            if ($strict) {
                $message = 'Do not pass a string for request options. If you want to set the '
                    . 'API key, pass an array like ["api_key" => <apiKey>] instead.';

                throw new \Swiftyper\Exception\InvalidArgumentException($message);
            }

            return new RequestOptions($options, [], null);
        }

        if (\is_array($options)) {
            $headers = [];
            $key = null;
            $base = null;

            if (\array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
                unset($options['api_key']);
            }
            if (\array_key_exists('swiftyper_account', $options)) {
                $headers['Swiftyper-Account'] = $options['swiftyper_account'];
                unset($options['swiftyper_account']);
            }
            if (\array_key_exists('api_base', $options)) {
                $base = $options['api_base'];
                unset($options['api_base']);
            }

            if ($strict && !empty($options)) {
                $message = 'Got unexpected keys in options array: ' . \implode(', ', \array_keys($options));

                throw new \Swiftyper\Exception\InvalidArgumentException($message);
            }

            return new RequestOptions($key, $headers, $base);
        }

        $message = 'The second argument to Swiftyper API method calls is an '
           . 'optional per-request apiKey, which must be a string, or '
           . 'per-request options, which must be an array. (HINT: you can set '
           . 'a global apiKey by "Swiftyper::setApiKey(<apiKey>)")';

        throw new \Swiftyper\Exception\InvalidArgumentException($message);
    }

    private function redactedApiKey()
    {
        $pieces = \explode('_', $this->apiKey, 3);
        $last = \array_pop($pieces);
        $redactedLast = \strlen($last) > 4
            ? (\str_repeat('*', \strlen($last) - 4) . \substr($last, -4))
            : $last;
        $pieces[] = $redactedLast;

        return \implode('_', $pieces);
    }
}
