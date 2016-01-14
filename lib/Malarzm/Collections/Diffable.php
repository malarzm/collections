<?php

namespace Malarzm\Collections;

abstract class Diffable extends AbstractCollection implements DiffableCollection
{
    use Mixin\Diffable;

    /**
     * @inheritdoc
     */
    abstract public function compare($a, $b);

    /**
     * Snapshots collection after creation.
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct($elements);
        $this->snapshot();
    }

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
        $this->elements[$key] = $value;
    }
}
