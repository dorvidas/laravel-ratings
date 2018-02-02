<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Dorvidas\Ratings\Tests\Models\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'user_id' => function () {
            return factory(\Dorvidas\Ratings\Tests\Models\User::class)->create()->id;
        }
    ];
});
