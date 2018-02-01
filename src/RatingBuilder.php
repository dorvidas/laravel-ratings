<?php

namespace Dorvidas\Ratings;

use Dorvidas\Ratings\Events\RatingCreatedEvent;
use Dorvidas\Ratings\Exceptions\RatingBuilderException;
use Dorvidas\Ratings\Models\Rating\Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RatingBuilder
{
    /**
     * Rated model
     *
     * @var string Model;
     */
    protected $model;


    /**
     * Model on which model is rated
     *
     * @var string
     */
    protected $onModel;


    /**
     * Model column
     *
     * @var string Column name;
     */
    protected $onModelColumn = 'user_id';


    /**
     * ID of user who is rating
     *
     * @var int
     */
    protected $by;

    /**
     * Rating
     *
     * @var int
     */
    protected $rating;

    /**
     * Set the rated model
     *
     * @param Model $model
     * @return $this
     */
    public function model(Model $model)
    {
        $this->model = $model;

        return $this;
    }


    /**
     * Set the model where model is rated on
     *
     * @param Model $model
     * @return $this
     */
    public function on(Model $model)
    {
        $this->onModel = $model;

        return $this;
    }

    /**
     * Set the column where role is held
     *
     * @param string $column
     * @return $this
     */
    public function as($column)
    {
        $this->onModelColumn = $column;

        return $this;
    }


    /**
     * Who is giving a rate
     *
     * @param int|object
     * @throws RatingBuilderException;
     * @return $this
     */
    public function by($user)
    {
        if (is_object($user)) {
            if (!isset($user->id)) {
                throw new RatingBuilderException('User object does not have ID');
            }
            $this->by = $user->id;
        } else {
            $this->by = $user;
        }

        return $this;
    }

    /**
     * Rate user
     *
     * @param int $rating
     * @throws RatingBuilderException;
     * @return Dorvidas\Ratings\Models\Rating;
     */
    public function give(int $rating)
    {
        $this->rating = $rating;

        $this->validate();

        $model = new \Dorvidas\Ratings\Models\Rating;
        $model->model = get_class($this->model);
        $model->model_id = $this->model->id;
        $model->on_model = $this->onModel ? get_class($this->onModel) : null;
        $model->on_model_id = $this->onModel ? $this->onModel->id : null;
        $model->on_model_column = $this->onModel ? $this->onModelColumn : null;
        $model->rated_by = $this->by ? $this->by : Auth::id();
        $model->rating = $rating;
        $model->save();

        return $model;
    }

    /**
     * Validates object data for saving
     *
     * @throws RatingBuilderException
     * @return void;
     */
    private function validate()
    {
        if (!$this->rating || $this->rating < 1 || $this->rating > 5) {
            throw new RatingBuilderException('Rating should be integer between 1-5');
        }

        if (!$this->model) {
            throw new RatingBuilderException('Model where user is rated unknown');
        }

        if (!$this->by && !Auth::id()) {
            throw new RatingBuilderException('Not sure who is giving a rate');
        }
    }

}