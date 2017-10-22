<?php

namespace Malarzm\Collections\ReadOnly;

use Malarzm\Collections\Mixin\ReadOnly;
use Malarzm\Collections\Set;

abstract class ReadOnlySet extends Set
{
    use ReadOnly;
}
