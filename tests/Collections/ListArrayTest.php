<?php

namespace Malarzm\Collections\Tests\Collections;

use Malarzm\Collections\ListArray;
use Malarzm\Collections\Tests\BaseTest;

class ListArrayTest extends BaseTest
{
    public function provideCollection()
    {
        return [
            [ new ListArray([1, 2, 3]), [1, 2, 3] ],
        ];
    }

    public function testConstructFixesElements()
    {
        $coll = new ListArray([ 3 => 1]);
        $this->assertSame([ 1 ], $coll->toArray());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidKey()
    {
        $coll = new ListArray();
        $coll['a'] = 'a';
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testSetOutOfRange()
    {
        $coll = new ListArray();
        $coll[1] = 'a';
    }

    public function testFunctional()
    {
        $coll = new ListArray();
        $coll[0] = 0;
        $coll->add(1);
        $coll->add(2);
        $coll->add(3);
        $coll->add(4);
        $this->assertSame([ 0, 1, 2, 3, 4 ], $coll->toArray());

        unset($coll[0]);
        $this->assertSame([ 1, 2, 3, 4 ], $coll->toArray());

        $coll->removeElement(2);
        $this->assertSame([ 1, 3, 4 ], $coll->toArray());

        $coll->remove(2);
        $this->assertSame([ 1, 3 ], $coll->toArray());

        $coll->remove(2);
        $this->assertSame([ 1, 3 ], $coll->toArray());
    }
}
