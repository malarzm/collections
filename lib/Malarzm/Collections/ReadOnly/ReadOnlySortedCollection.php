<?php

namespace Malarzm\Collections\ReadOnly;

use Malarzm\Collections\Mixin\ReadOnly;
use Malarzm\Collections\SortedCollection;

abstract class ReadOnlySortedCollection extends SortedCollection
{
    use ReadOnly;
}
