<?php

namespace Dorvidas\Ratings\Listeners;

use Dorvidas\Ratings\Models\Rating;
use Dorvidas\Ratings\Models\RatingAggregate;

class RecalculateRatingAggregatesListener
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $rating = $event->rating;

        $conditions = [
            'model' => $rating->model,
            'model_id' => $rating->model_id,
            'on_model' => $rating->on_model,
            'on_model_id' => $rating->on_model_id,
            'on_model_column' => $rating->on_model_column
        ];

        RatingAggregate::updateOrCreate(
            $conditions,
            array_merge($conditions,
                [
                    'average' => Rating::where('model', $rating->model)->where('model_id',
                        $rating->model_id)->avg('rating'),
                    'count' => Rating::where('model', $rating->model)->where('model_id', $rating->model_id)->count()
                ])
        );

    }


}
