<?php


namespace Malarzm\Collections\Tests\Collections\ReadOnly;

use Malarzm\Collections\ReadOnly\ReadOnlyArrayCollection;
use Malarzm\Collections\Tests\BaseReadOnlyTest;

class ReadOnlyArrayCollectionTest extends BaseReadOnlyTest
{
    public function provideCollection()
    {
        $associative = [ 'foo' => 1, 'bar' => 2, 7 ];
        return [
            [ new ReadOnlyArrayCollection([ 5, 7, 9 ]), [ 5, 7, 9] ],
            [ new ReadOnlyArrayCollection($associative), $associative ],
        ];
    }
}
