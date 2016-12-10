<?php

namespace Malarzm\Collections;

class ArrayCollection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    public function add($element)
    {
        $this->elements[] = $element;

        return true;
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
        $key = array_search($element, $this->elements, true);

        if ($key === false) {
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
        $this->elements[$key] = $value;
    }
}
