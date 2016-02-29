<?php

namespace Malarzm\Collections\Tests;

use Malarzm\Collections\SortedList;

class SortedListTest extends BaseTest
{
    public function provideCollection()
    {
        return [
            [ new SortedIntList([1, 2, 3]), [1, 2, 3] ],
        ];
    }

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

    public function testContainsThoroughly()
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

    public function testIndexOfThoroughly()
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

    public function testMapKeepsSortOrder()
    {
        $collection = new SortedObjectList();
        $collection->add((object) ['sortOrder' => 1]);
        $collection->add((object) ['sortOrder' => 2]);
        $collection->add((object) ['sortOrder' => 3]);

        $newCollection = $collection->map(function ($object) { return (array) $object; });

        $expected = [
            ['sortOrder' => 1],
            ['sortOrder' => 2],
            ['sortOrder' => 3],
        ];

        $this->assertSame($expected, $newCollection->toArray());
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

class SortedObjectList extends SortedList
{
    public function compare($a, $b)
    {
        if (! $a instanceof \stdClass || ! $b instanceof \stdClass) {
            return 0;
        }

        if (! isset($a->sortOrder, $b->sortOrder)) {
            return 0;
        }

        if ($a->sortOrder > $b->sortOrder) {
            return 1;
        } elseif ($a->sortOrder === $b->sortOrder) {
            return 0;
        } else {
            return -1;
        }
    }
}
