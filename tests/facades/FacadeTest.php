<?php

namespace Dorvidas\Ratings\Tests;

use Dorvidas\Ratings\RatingBuilder;
use Dorvidas\Ratings\Facades\Rate;

class FacadeTest extends TestCase
{

    /**
     * Test if facade returns RatingBuilder class instance
     *
     * @test
     */
    public function facade_works()
    {
        $this->assertEquals(RatingBuilder::class, get_class(Rate::getFacadeRoot()));
    }
}