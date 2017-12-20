<?php

namespace Malarzm\Collections\Tests\Collections;

use Malarzm\Collections\SortedCollection;
use Malarzm\Collections\Tests\BaseTest;

class SortedCollectionTest extends BaseTest
{
    public function provideCollection()
    {
        $associative = [ 'foo' => 1, 'bar' => 2, 5 ];
        return [
            [ new SortedIntCollection([ 5, 7, 9 ], 'usort'), [ 5, 7, 9] ],
            [ new SortedIntCollection($associative, 'uasort'), $associative ],
        ];
    }

    public function testFunctional()
    {
        $c = new SortedIntCollection([], 'usort');
        $c->add(6);
        $c->add(1);
        $c[] = 2;
        $this->assertSame([1, 2, 6], $c->toArray());
        $c->remove(1);
        $this->assertSame([1, 6], $c->toArray());
        $c[0] = 8;
        $this->assertSame([6, 8], $c->toArray());
    }

    public function testSortIsCalled()
    {
        $i = 0; $spy = new SortSpy();
        ++$i; $c = new SortedIntCollection([], $spy);
        ++$i; $c->add(1);
        ++$i; $c[] = 2;
        ++$i; $c[2] = 3;
        ++$i; $c->set(3, 4);
        ++$i; $c->removeElement(4);
        ++$i; $c->remove(2);
        ++$i; unset($c[1]);
        $this->assertEquals($i, $spy->cnt);
    }

    public function testMapKeepsSortOrder()
    {
        $collection = new SortedObjectCollection();
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

class SortedIntCollection extends SortedCollection
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

class SortedObjectCollection extends SortedCollection
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
