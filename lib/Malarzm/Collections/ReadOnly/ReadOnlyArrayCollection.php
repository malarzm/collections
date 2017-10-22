<?php

namespace Malarzm\Collections\ReadOnly;

use Malarzm\Collections\ArrayCollection;
use Malarzm\Collections\Mixin\ReadOnly;

class ReadOnlyArrayCollection extends ArrayCollection
{
    use ReadOnly;
}
