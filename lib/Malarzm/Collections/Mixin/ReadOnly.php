<?php

namespace Malarzm\Collections\Mixin;

trait ReadOnly
{
    /**
     * @throws \LogicException
     */
    public function clear()
    {
        throw new \LogicException('You can not modify a read only collection.');
    }

    /**
     * @throws \LogicException
     */
    public function add($element)
    {
        throw new \LogicException('You can not modify a read only collection.');
    }

    /**
     * @throws \LogicException
     */
    public function remove($key)
    {
        throw new \LogicException('You can not modify a read only collection.');
    }

    /**
     * @throws \LogicException
     */
    public function removeElement($element)
    {
        throw new \LogicException('You can not modify a read only collection.');
    }

    /**
     * @throws \LogicException
     */
    public function set($key, $value)
    {
        throw new \LogicException('You can not modify a read only collection.');
    }
}
