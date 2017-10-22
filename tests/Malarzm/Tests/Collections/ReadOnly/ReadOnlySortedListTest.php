<?php

namespace Malarzm\Collections\Tests\Collections\ReadOnly;

use Malarzm\Collections\ReadOnly\ReadOnlySortedList;

class ReadOnlySortedListTest extends \PHPUnit_Framework_TestCase
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
    }

    public function testIndexOfThoroughly()
    {
        $c = new SortedIntList([ 5, 9, 7, 1, 3 ]);
        $this->assertSame(0, $c->indexOf(1));
        $this->assertSame(1, $c->indexOf(3));
        $this->assertSame(2, $c->indexOf(5));
        $this->assertSame(3, $c->indexOf(7));
        $this->assertSame(4, $c->indexOf(9));
        $this->assertSame(false, $c->indexOf(666));
    }

    public function testMapKeepsSortOrder()
    {
        $collection = new SortedObjectList([
            (object) ['sortOrder' => 1],
            (object) ['sortOrder' => 2],
            (object) ['sortOrder' => 3],
        ]);

        $newCollection = $collection->map(function ($object) { return (array) $object; });

        $expected = [
            ['sortOrder' => 1],
            ['sortOrder' => 2],
            ['sortOrder' => 3],
        ];

        $this->assertSame($expected, $newCollection->toArray());
    }
}

class SortedIntList extends ReadOnlySortedList
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

class SortedObjectList extends ReadOnlySortedList
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
