<?php

namespace Malarzm\Collections\Tests;

use Malarzm\Collections\Set;

class SetTest extends BaseTest
{
    public function provideCollection()
    {
        $associative = [ 'foo' => 1, 'bar' => 2, 7 ];
        return [
            [ new IntSet([ 5, 7, 9 ]), [ 5, 7, 9] ],
            [ new IntSet($associative), $associative ],
        ];
    }

    public function testCantAddTwice()
    {
        $coll = new IntSet();
        $coll->add(13);
        $coll[] = 13;
        $this->assertCount(1, $coll);
    }

    public function testRemove()
    {
        $coll = new IntSet([ 13 ]);
        $this->assertSame(13, $coll->remove(0));
        $this->assertCount(0, $coll);
        $coll[] = 13;
        $this->assertNull($coll->remove(10));
        $this->assertCount(1, $coll);
    }

    public function testRemoveElement()
    {
        $coll = new IntSet([ 13 ]);
        $this->assertTrue($coll->removeElement(13));
        $this->assertCount(0, $coll);
        $coll[] = 13;
        $this->assertFalse($coll->removeElement(7));
        $this->assertCount(1, $coll);
    }

    public function testSetIsNoopIfElementIsAlreadyStored()
    {
        $coll = new IntSet([ 13, 7 ]);
        $coll->set(0, 7);
        $this->assertSame([ 13, 7 ], $coll->toArray());
    }

    public function testSetOverwritingValue()
    {
        $coll = new IntSet([ 13 ]);
        $coll[0] = 7;
        $this->assertCount(1, $coll);
        $coll[1] = 13;
        $this->assertCount(2, $coll);
    }
}

class IntSet extends Set
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
