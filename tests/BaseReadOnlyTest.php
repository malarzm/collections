<?php

namespace Malarzm\Collections\Tests;

use Doctrine\Common\Collections\Collection;

abstract class BaseReadOnlyTest extends BaseTest
{
    /**
     * @dataProvider provideCollection
     */
    public function testClearAndIsEmpty(Collection $coll)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        parent::testClearAndIsEmpty($coll);
    }


    /**
     * @dataProvider provideCollection
     */
    public function testAddIsProhibited(Collection $coll, array $elements)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        $coll->add(reset($elements));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testRemoveIsProhibited(Collection $coll, array $elements)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        $coll->remove(array_keys($elements)[0]);
    }

    /**
     * @dataProvider provideCollection
     */
    public function testRemoveElementIsProhibited(Collection $coll, array $elements)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        $coll->remove(reset($elements));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testSetIsProhibited(Collection $coll, array $elements)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        $coll->set(array_keys($elements)[0], reset($elements));
    }

    /**
     * @dataProvider provideCollection
     */
    public function testOffsetSetIsProhibited(Collection $coll, array $elements)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        $coll[array_keys($elements)[0]] = reset($elements);
    }

    /**
     * @dataProvider provideCollection
     */
    public function testOffsetRemoveIsProhibited(Collection $coll, array $elements)
    {
        $this->setExpectedException('\LogicException', 'You can not modify a read only collection.');
        unset($coll[array_keys($elements)[0]]);
    }
}
