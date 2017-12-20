<?php

namespace Malarzm\Collections\ReadOnly;

use Malarzm\Collections\Mixin\ReadOnly;
use Malarzm\Collections\SortedList;

abstract class ReadOnlySortedList extends SortedList
{
    use ReadOnly;
}
