<?php

namespace Dorvidas\Ratings\Tests;

use Dorvidas\Ratings\RatingBuilder;
use Dorvidas\Ratings\Tests\TestCase;

class RatingsServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_required_services()
    {
        $this->assertInstanceOf(RatingBuilder::class, resolve(RatingBuilder::class));
    }
}