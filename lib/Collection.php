<?php

namespace Swiftyper;

/**
 * Class Collection.
 *
 * @property string $object
 * @property string $url
 * @property bool $has_more
 * @property \Swiftyper\SwiftyperObject[] $data
 */
class Collection extends SwiftyperObject implements \Countable, \IteratorAggregate
{
    public function offsetGet($k)
    {
        if (\is_string($k)) {
            return parent::offsetGet($k);
        }
        $msg = "You tried to access the {$k} index, but Collection " .
            'types only support string keys. (HINT: List calls ' .
            'return an object with a `data` (which is the data ' .
            "array). You likely want to call ->data[{$k}])";

        throw new Exception\InvalidArgumentException($msg);
    }

    public function all($params = null, $opts = null)
    {
        self::_validateParams($params);
        list($url, $params) = $this->extractPathAndUpdateParams($params);

        list($response, $opts) = $this->_request('get', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response, $opts);
        if (!($obj instanceof \Swiftyper\Collection)) {
            throw new \Swiftyper\Exception\UnexpectedValueException(
                'Expected type ' . \Swiftyper\Collection::class . ', got "' . \get_class($obj) . '" instead.'
            );
        }
        $obj->setFilters($params);

        return $obj;
    }

    /**
     * @return int the number of objects in the current page
     */
    public function count()
    {
        return \count($this->data);
    }

    /**
     * @return \ArrayIterator an iterator that can be used to iterate
     *    across objects in the current page
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @return \ArrayIterator an iterator that can be used to iterate
     *    backwards across objects in the current page
     */
    public function getReverseIterator()
    {
        return new \ArrayIterator(\array_reverse($this->data));
    }

    /**
     * Returns an empty collection. This is returned from {@see nextPage()}
     * when we know that there isn't a next page in order to replicate the
     * behavior of the API when it attempts to return a page beyond the last.
     *
     * @param null|array|string $opts
     *
     * @return Collection
     */
    public static function emptyCollection($opts = null)
    {
        return Collection::constructFrom(['data' => []], $opts);
    }

    /**
     * Gets the first item from the current page. Returns `null` if the current page is empty.
     *
     * @return null|\Swiftyper\SwiftyperObject
     */
    public function first()
    {
        return \count($this->data) > 0 ? $this->data[0] : null;
    }

    /**
     * Gets the last item from the current page. Returns `null` if the current page is empty.
     *
     * @return null|\Swiftyper\SwiftyperObject
     */
    public function last()
    {
        return \count($this->data) > 0 ? $this->data[\count($this->data) - 1] : null;
    }

    private function extractPathAndUpdateParams($params)
    {
        $url = \parse_url($this->url);
        if (!isset($url['path'])) {
            throw new Exception\UnexpectedValueException("Could not parse list url into parts: {$url}");
        }

        if (isset($url['query'])) {
            // If the URL contains a query param, parse it out into $params so they
            // don't interact weirdly with each other.
            $query = [];
            \parse_str($url['query'], $query);
            $params = \array_merge($params ?: [], $query);
        }

        return [$url['path'], $params];
    }
}
