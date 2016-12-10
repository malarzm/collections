<?php

namespace Malarzm\Collections;

use Closure;

abstract class SortedCollection extends AbstractCollection
{
    /**
     * Callable called for sorting.
     *
     * @var callable
     */
    private $sort;

    /**
     * The compare method must return an integer less than, equal to, or greater than zero if the first argument is
     * considered to be respectively less than, equal to, or greater than the second.
     *
     * @param mixed $a
     * @param mixed $b
     * @return int
     */
    abstract public function compare($a, $b);

    /**
     * Initializes a new SortedCollection.
     *
     * @param array $elements
     * @param callable $sort uasort is used by default
     * @param boolean $sortElements If true, elements will be sorted when creating the collection
     */
    public function __construct(array $elements = [], callable $sort = null, $sortElements = true)
    {
        parent::__construct($elements);
        $this->sort = $sort !== null ? $sort : 'uasort';

        if ($sortElements) {
            call_user_func_array($this->sort, [&$this->elements, [$this, 'compare']]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createFrom(array $elements)
    {
        return new static($elements, $this->sort, false);
    }

    /**
     * @inheritdoc
     */
    public function add($value)
    {
        $this->elements[] = $value;
        call_user_func_array($this->sort, [&$this->elements, [$this, 'compare']]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function indexOf($element)
    {
        foreach ($this->elements as $i => $e) {
            if ($this->compare($element, $e) === 0) {
                return $i;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        if ( ! isset($this->elements[$key]) && ! array_key_exists($key, $this->elements)) {
            return null;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);
        call_user_func_array($this->sort, [&$this->elements, [$this, 'compare']]);

        return $removed;
    }

    /**
     * @inheritdoc
     */
    public function removeElement($element)
    {
        $key = $this->indexOf($element);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);
        call_user_func_array($this->sort, [&$this->elements, [$this, 'compare']]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;
        call_user_func_array($this->sort, [&$this->elements, [$this, 'compare']]);
    }
}
