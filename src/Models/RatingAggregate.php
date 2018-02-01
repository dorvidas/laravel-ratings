<?php

namespace Dorvidas\Ratings\Models;

use Illuminate\Database\Eloquent\Model;

class RatingAggregate extends Model
{

    protected $fillable = [
        'model',
        'model_id',
        'on_model',
        'on_model_id',
        'on_model_column',
        'average',
        'count'
    ];

    public function __construct()
    {
        $this->table = config('ratings.database_prefix') . 'rating_aggregates';
    }

    public function rateable()
    {
        return $this->morphTo();
    }

}
