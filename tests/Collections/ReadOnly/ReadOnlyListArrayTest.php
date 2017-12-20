<?php

namespace Malarzm\Collections\Tests\Collections\ReadOnly;

use Malarzm\Collections\ReadOnly\ReadOnlyListArray;
use Malarzm\Collections\Tests\BaseReadOnlyTest;

class ReadOnlyListArrayTest extends BaseReadOnlyTest
{
    public function provideCollection()
    {
        return [
            [ new ReadOnlyListArray([1, 2, 3]), [1, 2, 3] ],
        ];
    }

    public function testConstructFixesElements()
    {
        $coll = new ReadOnlyListArray([ 3 => 1]);
        $this->assertSame([ 1 ], $coll->toArray());
    }
}
