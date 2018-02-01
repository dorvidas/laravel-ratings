<?php

namespace Dorvidas\Ratings\Events;
use Dorvidas\Ratings\Models\Rating;
use Illuminate\Queue\SerializesModels;

class RatingCreatedEvent
{

    use SerializesModels;

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