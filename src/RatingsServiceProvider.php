<?php

namespace Dorvidas\Ratings;

use Illuminate\Support\ServiceProvider;

class RatingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (isNotLumen()) {
            $this->publishes([
                __DIR__ . '/../config/ratings.php' => config_path('ratings.php'),
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RatingBuilder::class, function () {
            return new RatingBuilder();
        });
        $this->app->alias(RatingBuilder::class, 'rating');
    }
}