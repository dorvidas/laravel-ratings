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
     * Build query builder and return it.
     *
     * @param null|string $onModel
     * @param string $onModelColumn
     * @return Builder
     */
    public function ratings($onModel = null, $onModelColumn = 'user_id')
    {
        $builder = Rating::where('model', get_class($this))->where('model_id', $this->id);

        if ($onModel) {
            $builder->where('on_model', $onModel);
            $builder->where('on_model_column', $onModelColumn);
        }

        return $builder;
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
