<?php

namespace Malarzm\Collections\Tests\Collections\ReadOnly;

use Malarzm\Collections\ReadOnly\ReadOnlySet;
use Malarzm\Collections\Tests\BaseReadOnlyTest;

class ReadOnlySetTest extends BaseReadOnlyTest
{
    public function provideCollection()
    {
        $associative = [ 'foo' => 1, 'bar' => 2, 7 ];
        return [
            [ new ReadOnlyIntSet([ 5, 7, 9 ]), [ 5, 7, 9] ],
            [ new ReadOnlyIntSet($associative), $associative ],
        ];
    }
}

class ReadOnlyIntSet extends ReadOnlySet
{
    public function compare($a, $b)
    {
        if ($a > $b) {
            return 1;
        } elseif ($a === $b) {
            return 0;
        } else {
            return -1;
        }
    }
}
