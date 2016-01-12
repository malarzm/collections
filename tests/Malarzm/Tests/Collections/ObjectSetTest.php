<?php

namespace Malarzm\Collections\Tests;

use Malarzm\Collections\ObjectSet;

class ObjectSetTest extends \PHPUnit_Framework_TestCase
{
    public function testCantAddObjectTwice()
    {
        $o = new \stdClass();
        $coll = new ObjectSet();
        $coll->add($o);
        $coll[] = $o;
        $this->assertCount(1, $coll);
    }

    public function testConstructRegistersObjects()
    {
        $o = new \stdClass();
        $coll = new ObjectSet([ $o ]);
        $this->assertCount(1, $coll);
        $coll->add($o);
        $this->assertCount(1, $coll);
    }

    public function testRemove()
    {
        $o = new \stdClass();
        $coll = new ObjectSet([ $o ]);
        $this->assertSame($o, $coll->remove(0));
        $this->assertCount(0, $coll);
        $coll[] = $o;
        $this->assertNull($coll->remove(10));
        $this->assertCount(1, $coll);
    }

    public function testRemoveElement()
    {
        $o = new \stdClass();
        $coll = new ObjectSet([ $o ]);
        $this->assertTrue($coll->removeElement($o));
        $this->assertCount(0, $coll);
        $coll[] = $o;
        $this->assertFalse($coll->removeElement(new \stdClass()));
        $this->assertCount(1, $coll);
    }

    public function testSetIsNoopIfObjectIsAlreadyStored()
    {
        $o1 = new \stdClass();
        $o2 = new \stdClass();
        $coll = new ObjectSet([ $o1, $o2 ]);
        $coll->set(0, $o2);
        $this->assertSame([ $o1, $o2 ], $coll->toArray());
    }

    public function testSetOverwritingObject()
    {
        $o1 = new \stdClass();
        $o2 = new \stdClass();
        $coll = new ObjectSet([ $o1 ]);
        $coll[0] = $o2;
        $this->assertCount(1, $coll);
        $coll[1] = $o1;
        $this->assertCount(2, $coll);
    }

    public function testContains()
    {
        $o1 = new \stdClass();
        $o2 = new \stdClass();
        $coll = new ObjectSet([ $o1 ]);
        $this->assertTrue($coll->contains($o1));
        $this->assertFalse($coll->contains($o2));
    }
}