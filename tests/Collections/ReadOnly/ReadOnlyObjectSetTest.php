<?php

namespace Malarzm\Collections\Tests\Collections\ReadOnly;

use Doctrine\Common\Collections\Collection;
use Malarzm\Collections\ReadOnly\ReadOnlyObjectSet;
use Malarzm\Collections\Tests\BaseReadOnlyTest;

class ReadOnlyObjectSetTest extends BaseReadOnlyTest
{
    public function provideCollection()
    {
        $elements = [ new \stdClass(), new \stdClass(), new \stdClass() ];
        return [
            [ new ReadOnlyObjectSet($elements), $elements ],
        ];
    }

    /**
     * @dataProvider provideCollection
     */
    public function testContains(Collection $coll, array $elements)
    {
        $this->assertTrue($coll->contains($coll->first()));
        $this->assertFalse($coll->contains(new \stdClass()));
    }
}
