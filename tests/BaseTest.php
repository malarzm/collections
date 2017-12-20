<?php

namespace Malarzm\Collections\Tests;

use Doctrine\Common\Collections\Collection;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    abstract public function provideCollection();

    /**
     * @dataProvider provideCollection
     */
    public function testToArray(Collection $coll, array $elements)
    {
        $this->assertSame($elements, $coll->toArray());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testFirst(Collection $coll, array $elements)
    {
        $this->assertSame(reset($elements), $coll->first());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testLast(Collection $coll, array $elements)
    {
        $this->assertSame(end($elements), $coll->last());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testKey(Collection $coll, array $elements)
    {
        $this->assertSame(key($elements), $coll->key());

        next($elements);
        $coll->next();

        $this->assertSame(key($elements), $coll->key());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testNext(Collection $coll, array $elements)
    {
        while (true) {
            $collectionNext = $coll->next();
            $arrayNext = next($elements);

            if(! $collectionNext || ! $arrayNext) {
                break;
            }

            $this->assertSame($arrayNext, $collectionNext, "Returned value of ArrayCollection::next() and next() not match");
            $this->assertSame(key($elements), $coll->key(), "Keys not match");
            $this->assertSame(current($elements), $coll->current(), "Current values not match");
        }
    }

    /**
     * @dataProvider provideCollection
     */
    public function testCurrent(Collection $coll, array $elements)
    {
        $this->assertSame(current($elements), $coll->current());

        next($elements);
        $coll->next();

        $this->assertSame(current($elements), $coll->current());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testGetKeys(Collection $coll, array $elements)
    {
        $this->assertSame(array_keys($elements), $coll->getKeys());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testGetValues(Collection $coll, array $elements)
    {
        $this->assertSame(array_values($elements), $coll->getValues());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testCount(Collection $coll, array $elements)
    {
        $this->assertCount(count($elements), $coll);
        $this->assertSame(count($elements), $coll->count());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testIterator(Collection $coll, array $elements)
    {
        $iterations = 0;
        foreach($coll->getIterator() as $key => $item) {
            $this->assertSame($elements[$key], $item, "Item {$key} not match");
            $iterations++;
        }

        $this->assertEquals(count($elements), $iterations, "Number of iterations not match");
    }

    /**
     * @dataProvider provideCollection
     */
    public function testClearAndIsEmpty(Collection $coll)
    {
        $this->assertFalse($coll->isEmpty());
        $coll->clear();
        $this->assertSame([], $coll->toArray());
        $this->assertTrue($coll->isEmpty());
    }

    /**
     * @dataProvider provideCollection
     */
    public function testContains(Collection $coll, array $elements)
    {
        $this->assertTrue($coll->contains(current($elements)));
        $this->assertTrue($coll->contains(end($elements)));
        $this->assertFalse($coll->contains('this-will-surely-not-exist'));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testContainsKey(Collection $coll, array $elements)
    {
        $keys = array_keys($elements);
        $this->assertTrue($coll->containsKey(current($keys)));
        $this->assertTrue($coll->containsKey(end($keys)));
        $this->assertFalse($coll->containsKey('this-will-surely-not-exist'));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testIndexOf(Collection $coll, array $elements)
    {
        $keys = array_keys($elements);
        $this->assertSame(current($keys), $coll->indexOf(current($elements)));
        $this->assertSame(end($keys), $coll->indexOf(end($elements)));
        $this->assertFalse($coll->indexOf('this-will-surely-not-exist'));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testSlice(Collection $coll, array $elements)
    {
        $this->assertSame(array_slice($elements, 0, -1, true), $coll->slice(0, -1));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testMapCreatesCorrectInstance(Collection $coll)
    {
        $this->assertInstanceOf(get_class($coll), $coll->map(function($a) { return $a; }));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testFilter(Collection $coll)
    {
        $filtered = $coll->filter(function() { return false; });
        $this->assertInstanceOf(get_class($coll), $filtered);
        $this->assertCount(0, $filtered);
    }

    /**
     * @dataProvider provideCollection
     */
    public function testPartitionCreatesCorrectInstance(Collection $coll, array $elements)
    {
        list($match, $noMatch) = $coll->partition(function() { return true; });
        $this->assertInstanceOf(get_class($coll), $match);
        $this->assertInstanceOf(get_class($coll), $noMatch);
        $this->assertCount(0, $noMatch);
        $this->assertCount(count($elements), $match);
    }
}
