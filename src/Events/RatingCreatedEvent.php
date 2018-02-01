<?php

namespace Dorvidas\Ratings\Events;
use Dorvidas\Ratings\Models\Rating;
use App\Events\Event;

class RatingCreatedEvent extends Event
{

    public $rating;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

}