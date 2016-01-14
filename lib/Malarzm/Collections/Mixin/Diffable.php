<?php

namespace Malarzm\Collections\Mixin;

trait Diffable
{
    private $snapshot = [];

    public function getAddedElements()
    {
        return array_values(array_udiff(
            $this->toArray(),
            $this->snapshot,
            [ $this, 'compare' ]
        ));
    }

    public function getRemovedElements()
    {
        return array_values(array_udiff(
            $this->snapshot,
            $this->toArray(),
            [ $this, 'compare' ]
        ));
    }

    public function snapshot()
    {
        $this->snapshot = $this->toArray();
    }
}
