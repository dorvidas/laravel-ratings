<?php

namespace Dorvidas\Ratings\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    protected $dispatchesEvents = [
        'created' => \Dorvidas\Ratings\Events\RatingCreatedEvent::class,
    ];

    public function __construct()
    {
        $this->table = config('ratings.database_prefix') . 'ratings';
    }

}
