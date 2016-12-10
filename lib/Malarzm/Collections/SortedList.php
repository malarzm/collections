<?php

namespace Malarzm\Collections;

use Closure;

abstract class SortedList extends ListArray
{
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
     * Initializes SortedList ensuring that elements are in fact a sorted list.
     *
     * @param array $elements
     * @param boolean $sortElements If true, elements will be sorted when creating the list
     */
    public function __construct(array $elements = [], $sortElements = true)
    {
        parent::__construct($elements);

        if ($sortElements) {
            usort($this->elements, [ $this, 'compare' ]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createFrom(array $elements)
    {
        return new static($elements, false);
    }

    /**
     * @inheritdoc
     */
    public function add($element)
    {
        parent::add($element);
        usort($this->elements, [ $this, 'compare' ]);
    }

    /**
     * Checks whether an element is contained in the collection.
     * Contrary to standard implementation this is an O(log n) operation, where n is the size of the collection.
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element)
    {
        return $this->indexOf($element) !== false;
    }

    /**
     * Gets the index of given element.
     * Contrary to standard implementation this is an O(log n) operation, where n is the size of the collection.
     *
     * @param mixed $element
     * @return int|bool
     */
    public function indexOf($element)
    {
        $start = 0; $end = count($this->elements) - 1;
        while ($start <= $end) {
            $middle = (int) (($start + $end) / 2);
            $cmp = $this->compare($element, $this->elements[$middle]);
            if ($cmp === 0) {
                return $middle;
            } elseif ($cmp < 0) {
                $end = $middle - 1;
            } else {
                $start = $middle + 1;
            }
        }
        return false;
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
        $this->elements = array_values($this->elements);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        parent::set($key, $value);
        usort($this->elements, [ $this, 'compare' ]);
    }
}
