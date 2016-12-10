<?php

namespace Malarzm\Collections;

use ArrayIterator;
use Closure;
use Doctrine\Common\Collections\Collection;

abstract class AbstractCollection implements Collection
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    protected $elements = [];

    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Creates a new instance from the specified elements.
     *
     * This method is provided for derived classes to specify how a new
     * instance should be created when constructor semantics have changed.
     *
     * @param array $elements Elements.
     *
     * @return static
     */
    protected function createFrom(array $elements)
    {
        return new static($elements);
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * @inheritdoc
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if ( ! isset($offset)) {
            return $this->add($value);
        }

        $this->set($offset, $value);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * @inheritdoc
     */
    public function containsKey($key)
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    /**
     * @inheritdoc
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * @inheritdoc
     */
    public function exists(Closure $p)
    {
        foreach ($this->elements as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return isset($this->elements[$key]) ? $this->elements[$key] : null;
    }

    /**
     * @inheritdoc
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return empty($this->elements);
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * @inheritdoc
     */
    public function map(Closure $func)
    {
        return $this->createFrom(array_map($func, $this->elements));
    }

    /**
     * @inheritdoc
     */
    public function filter(Closure $p)
    {
        return $this->createFrom(array_filter($this->elements, $p));
    }

    /**
     * @inheritdoc
     */
    public function forAll(Closure $p)
    {
        foreach ($this->elements as $key => $element) {
            if ( ! $p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function partition(Closure $p)
    {
        $matches = $noMatches = array();

        foreach ($this->elements as $key => $element) {
            if ($p($key, $element)) {
                $matches[$key] = $element;
            } else {
                $noMatches[$key] = $element;
            }
        }

        return array($this->createFrom($matches), $this->createFrom($noMatches));
    }

    /**
     * Returns a string representation of this object.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . '@' . spl_object_hash($this);
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->elements = array();
    }

    /**
     * @inheritdoc
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->elements, $offset, $length, true);
    }
}
