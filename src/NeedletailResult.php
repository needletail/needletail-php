<?php

namespace Needletail;

use Countable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class NeedletailResult implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    private $items;

    /**
     * Create a new collection.
     *
     * @param  array  $items
     * @return void
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Get the collection of items as Laravel collection.
     *
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Exception
     */
    public function toCollection()
    {
        if (!class_exists('\Tightenco\Collect\Support\Collection'))
            throw new \Exception('Cannot use the toCollection method unless you include the tightenco/collect package');

        return new \Tightenco\Collect\Support\Collection($this->items);
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        $items = $this->items;

        if (isset($this->items['data'])) {
            $items = $this->items['data'];
        }

        return count($items);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Dynamically access collection proxies.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        $items = $this->items[$key] ?? null;

        if (! is_array($items))
            return $items;

        return new $this($items);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}