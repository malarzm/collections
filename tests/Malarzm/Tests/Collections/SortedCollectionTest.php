<?php

namespace Malarzm\Collections\Tests;

use Malarzm\Collections\SortedCollection;

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

class SortSpy
{
    public $cnt = 0;

    public function __invoke(& $elements, $comp)
    {
        $this->cnt++;
        usort($elements, $comp);
    }
}
