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

    public function scopeOf($query, $model)
    {
        return $query->where('model', get_class($model))->where('model_id', $model->id);
    }

    public function scopeModel($query, $model)
    {
        return $query->where('model', is_object($model) ? get_class($model) : $model);
    }

    public function scopeModelId($query, $modelId)
    {
        return $query->where('model_id', $modelId);
    }

    public function scopeOn($query, $model)
    {
        return $query->where('on_model', get_class($model))->where('on_model_id', $model->id);
    }

    public function scopeOnModel($query, $model)
    {
        return $query->where('on_model', $model);
    }

    public function scopeOnModelId($query, $modelId)
    {
        return $query->where('on_model_id', $modelId);
    }

    public function scopeAs($query, $column)
    {
        return $query->where('on_model_column', $column);
    }

    public function scopeBy($query, $userId)
    {
        return $query->where('rated_by', $userId);
    }


}
