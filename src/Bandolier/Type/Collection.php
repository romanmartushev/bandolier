<?php
/**
 * Collection
 *
 * Created 6/9/17 12:37 PM
 * Simple collection builder
 * Based on https://www.sitepoint.com/collection-classes-in-php/
 *
 * @author Nate Nolting <naten@paulbunyan.net>
 * @package Pbc\Bandolier\Type
 */

namespace Pbc\Bandolier\Type;

use Pbc\Bandolier\Exception\Collection\KeyHasUseException;
use Pbc\Bandolier\Exception\Collection\KeyInvalidException;

/**
 * Class Collection
 * @package Pbc\Bandolier\Type
 */
class Collection extends BaseType
{
    /**
     * @var array
     */
    protected array $items = array();

    /**
     * Add an item to the collection by key
     * @param $obj
     * @param null|string|int $key
     * @return $this
     * @throws KeyHasUseException
     */
    public function addItem($obj, $key = null)
    {
        if ($key == null) {
            $this->items[] = $obj;
        } else {
            if (array_key_exists($key, $this->getItems())) {
                throw new KeyHasUseException("Key $key already in use.");
            } else {
                $this->items[$key] = $obj;
            }
        }

        return $this;
    }

    /**
     * @param $list
     * @param null $key
     * @param array $list
     *
     * @return $this
     *
     * @throws KeyHasUseException
     */
    public function addItems($list)
    {
        array_walk($list, fn($val, $key) => $this->addItem($val, $key));
        return $this;
    }

    /**
     * Set a collection item by key
     * @param $obj
     * @param mixed $key
     * @return $this
     * @throws KeyInvalidException
     */
    public function setItem($obj, string $key)
    {
        if (!array_key_exists($key, $this->getItems())) {
            throw new KeyInvalidException("Invalid key $key.");
        }
        $this->items[$key] = $obj;

        return $this;
    }

    /**
     * Delete a collection key
     * @param $key
     * @return $this
     * @throws KeyInvalidException
     */
    public function deleteItem(string $key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            throw new KeyInvalidException("Invalid key $key.");
        }
        return $this;
    }

    /**
     * Get a collection item
     * @param $key
     * @return mixed
     * @throws KeyInvalidException
     */
    public function getItem($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            throw new KeyInvalidException("Invalid key $key.");
        }
    }

    /**
     * List out all the keys
     * @return array
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     * Get the number of keys in collection
     * @return int
     */
    public function length()
    {
        return count($this->items);
    }

    /**
     * Check if key exist in collection
     * @param $key
     * @return bool
     */
    public function keyExists($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
