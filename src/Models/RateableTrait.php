<?php

namespace Dorvidas\Ratings\Models;

use Dorvidas\Ratings\RatingBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait RateableTrait
{

    /**
     * Set the model in RatingBuilder and return it.
     *
     * @return RatingBuilder
     */
    public function rate()
    {
        $builder = new RatingBuilder();
        $builder->model($this);

        return $builder;
    }

    /**
     * Get ratings relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class
            , 'model'
            , 'model'
            , 'model_id'
        );
    }

    /**
     * Get ralation
     *
     * @return Builder
     */

    public function rating_aggregates()
    {
        return $this->morphMany(\Dorvidas\Ratings\Models\RatingAggregate::class
            , 'model'
            , 'model'
            , 'model_id'
        );
    }


}
