<?php

namespace Malarzm\Collections\Tests;

use Malarzm\Collections\SortedList;

class SortedListTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructFixesElements()
    {
        $c = new SortedIntList([ 1 => 8, 3 => 4, 8 => 9 ]);
        $this->assertSame([4, 8, 9], $c->toArray());
    }

    public function testFunctional()
    {
        $c = new SortedIntList();
        $c->add(6);
        $c->add(1);
        $c[] = 2;
        $this->assertSame([1, 2, 6], $c->toArray());
        $c->remove(1);
        $this->assertSame([1, 6], $c->toArray());
        $c[0] = 8;
        $this->assertSame([6, 8], $c->toArray());
    }

    public function testContains()
    {
        $c = new SortedIntList([ 5, 9, 7, 1, 3 ]);
        $this->assertFalse($c->contains(0));
        $this->assertTrue($c->contains(1));
        $this->assertFalse($c->contains(2));
        $this->assertTrue($c->contains(3));
        $this->assertFalse($c->contains(4));
        $this->assertTrue($c->contains(5));
        $this->assertFalse($c->contains(6));
        $this->assertTrue($c->contains(7));
        $this->assertFalse($c->contains(8));
        $this->assertTrue($c->contains(9));
        $this->assertFalse($c->contains(10));

        $c[] = 10;
        $this->assertFalse($c->contains(0));
        $this->assertTrue($c->contains(1));
        $this->assertFalse($c->contains(2));
        $this->assertTrue($c->contains(3));
        $this->assertFalse($c->contains(4));
        $this->assertTrue($c->contains(5));
        $this->assertFalse($c->contains(6));
        $this->assertTrue($c->contains(7));
        $this->assertFalse($c->contains(8));
        $this->assertTrue($c->contains(9));
        $this->assertTrue($c->contains(10));
        $this->assertFalse($c->contains(11));
    }

    public function testIndexOf()
    {
        $c = new SortedIntList([ 5, 9, 7, 1, 3 ]);
        $this->assertSame(0, $c->indexOf(1));
        $this->assertSame(1, $c->indexOf(3));
        $this->assertSame(2, $c->indexOf(5));
        $this->assertSame(3, $c->indexOf(7));
        $this->assertSame(4, $c->indexOf(9));

        $c[] = 10;
        $this->assertSame(5, $c->indexOf(10));
    }
}

class SortedIntList extends SortedList
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
