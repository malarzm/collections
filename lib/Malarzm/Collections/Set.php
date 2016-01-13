<?php

namespace Malarzm\Collections;

abstract class Set extends AbstractCollection
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
     * @inheritdoc
     */
    public function add($element)
    {
        if ($this->contains($element)) {
            return;
        }

        $this->elements[] = $element;
    }

    /**
     * @inheritdoc
     */
    public function contains($element)
    {
        foreach ($this->elements as $e) {
            if ($this->compare($element, $e) === 0) {
                return true;
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

        return $removed;
    }

    /**
     * @inheritdoc
     */
    public function removeElement($element)
    {
        $key = null;
        foreach ($this->elements as $i => $e) {
            if ($this->compare($element, $e) === 0) {
                $key = $i;
                break;
            }
        }

        if ($key === null) {
            return false;
        }

        unset($this->elements[$key]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        if ($this->contains($value)) {
            return;
        }

        $this->elements[$key] = $value;
    }
}
