<?php

namespace Malarzm\Collections\Tests\Collections\ReadOnly;

use Malarzm\Collections\ReadOnly\ReadOnlySortedCollection;
use Malarzm\Collections\Tests\BaseReadOnlyTest;

class ReadOnlySortedCollectionTest extends BaseReadOnlyTest
{
    public function provideCollection()
    {
        $associative = [ 'foo' => 1, 'bar' => 2, 5 ];
        return [
            [ new SortedIntCollection([ 5, 7, 9 ], 'usort'), [ 5, 7, 9] ],
            [ new SortedIntCollection($associative, 'uasort'), $associative ],
        ];
    }

    public function testSortIsCalled()
    {
        $i = 0; $spy = new SortSpy();
        ++$i; $c = new SortedIntCollection([2, 1], $spy);
        $this->assertEquals($i, $spy->cnt);
    }

    public function testMapKeepsSortOrder()
    {
        $collection = new SortedObjectCollection([
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

class SortedIntCollection extends ReadOnlySortedCollection
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

class SortedObjectCollection extends ReadOnlySortedCollection
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

class SortSpy
{
    public $cnt = 0;

    public function __invoke(& $elements, $comp)
    {
        $this->cnt++;
        usort($elements, $comp);
    }
}
