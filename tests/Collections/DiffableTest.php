<?php

namespace Malarzm\Collections\Tests\Collections;

use Malarzm\Collections\Diffable;
use Malarzm\Collections\Tests\BaseTest;

class DiffableTest extends BaseTest
{
    public function provideCollection()
    {
        $associative = [ 'foo' => 1, 'bar' => 2, 'baz' ];
        return [
            [ new DiffableImpl([ 5, 7, 9 ]), [ 5, 7, 9] ],
            [ new DiffableImpl($associative), $associative ],
        ];
    }

    public function testConstructSnapshots()
    {
        $coll = new DiffableImpl([ 5, 7 ]);
        $this->assertEmpty($coll->getAddedElements());
        $this->assertEmpty($coll->getRemovedElements());
        $coll->add(6);
        $this->assertSame([ 6 ], $coll->getAddedElements());
        $coll->removeElement(5);
        $this->assertSame([ 5 ], $coll->getRemovedElements());
    }

    public function testFunctional()
    {
        $coll = new DiffableImpl();
        $coll->add(6);
        $this->assertSame([ 6 ], $coll->getAddedElements());
        $this->assertEmpty($coll->getRemovedElements());
        $coll->snapshot();

        $coll->removeElement(5);
        $this->assertSame([  ], $coll->getRemovedElements());
        $coll->removeElement(6);
        $this->assertSame([ 6 ], $coll->getRemovedElements());
        $coll->snapshot();

        $coll[0] = 0;
        $coll[1] = 1;
        $coll[0] = 13;
        $this->assertSame([ 13, 1 ], $coll->getAddedElements());
        unset($coll[1]);
        $this->assertSame([ 13 ], $coll->getAddedElements());
        $this->assertEmpty($coll->getRemovedElements());
        $coll->snapshot();

        unset($coll[0]);
        $this->assertSame([ 13 ], $coll->getRemovedElements());
    }
}

class DiffableImpl extends Diffable
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
