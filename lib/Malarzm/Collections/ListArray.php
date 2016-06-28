<?php

namespace Malarzm\Collections;

class ListArray extends AbstractCollection
{
    /**
     * Initializes ListArray numerically reindexing provided elements.
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(array_values($elements));
    }

    /**
     * @inheritdoc
     */
    public function add($element)
    {
        $this->elements[] = $element;
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
        $this->elements = array_values($this->elements);

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
        $this->elements = array_values($this->elements);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        if ( ! is_numeric($key)) {
            throw new \InvalidArgumentException(__CLASS__ . ' index must be a number, "' . $key . '" given.');
        }
        $key = (int) $key;
        if ($key < 0 || count($this->elements) < $key) {
            throw new \OutOfBoundsException();
        }
        $this->elements[$key] = $value;
    }
}
