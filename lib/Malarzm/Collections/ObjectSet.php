<?php

namespace Malarzm\Collections;

class ObjectSet extends AbstractCollection
{
    private $hashes = [];

    public function __construct(array $elements = [])
    {
        parent::__construct($elements);
        foreach ($this->elements as $element) {
            $this->hashes[spl_object_hash($element)] = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function add($element)
    {
        $oid = spl_object_hash($element);

        if (isset($this->hashes[$oid])) {
            return;
        }

        $this->elements[] = $element;
        $this->hashes[$oid] = true;
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        parent::clear();
        $this->hashes = [];
    }

    /**
     * Checks whether an element is contained in the collection.
     * Contrary to standard implementation this is an O(1) operation.
     *
     * @param object $element
     * @return bool
     */
    public function contains($element)
    {
        return isset($this->hashes[spl_object_hash($element)]);
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
        unset($this->hashes[spl_object_hash($removed)]);

        return $removed;
    }

    /**
     * @inheritdoc
     */
    public function removeElement($element)
    {
        $oid = spl_object_hash($element);

        if ( ! isset($this->hashes[$oid])) {
            return false;
        }

        $key = $this->indexOf($element);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);
        unset($this->hashes[$oid]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        $oid = spl_object_hash($value);

        if (isset($this->hashes[$oid])) {
            return;
        }

        if (isset($this->elements[$key])) {
            unset($this->hashes[spl_object_hash($this->elements[$key])]);
        }

        $this->elements[$key] = $value;
        $this->hashes[$oid] = true;
    }
}
