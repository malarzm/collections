<?php

namespace Malarzm\Collections;

use Doctrine\Common\Collections\Collection;

interface DiffableCollection extends Collection
{
    /**
     * The compare method must return an integer less than, equal to, or greater than zero if the first argument is
     * considered to be respectively less than, equal to, or greater than the second.
     *
     * @param mixed $a
     * @param mixed $b
     * @return int
     */
    public function compare($a, $b);

    /**
     * Get elements that were added to the collection.
     *
     * @return array
     */
    public function getAddedElements();

    /**
     * Get elements that were removed from the collection.
     *
     * @return array
     */
    public function getRemovedElements();

    /**
     * Snapshots current elements.
     *
     * @return void
     */
    public function snapshot();
}
