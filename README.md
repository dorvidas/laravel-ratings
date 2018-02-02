# Laravel ratings
Rate users, posts or other models with ease. You can even give a rating to a user for their role on other models i.e., post author or post illustator.

* [Installation](#installation)
  * [Lumen](#lumen)
  * [Laravel](#laravel)
* [Usage](#usage)
  * [Giving a rating](#giving-a-rating)
  * [Getting a ratings of model](#getting-a-ratings)
  * [Getting ratings aggregates](#getting-rating-aggregates)
* [Config](#config)

## Installation

* [Laravel](#test)
* [Lumen](#lumen)

### Lumen

You can install this package via composer using this command:

```bash
composer require dorvidas/laravel-ratings
```

Include service provider and config into `bootstrap/app.php`:
```php
$app->register(\Dorvidas\Ratings\RatingsServiceProvider::class);
$app->configure('ratings');
```

### Laravel

You can install this package via composer using this command:
```bash
composer require dorvidas/laravel-ratings
```

Add service provider:
```php
Dorvidas\Ratings\RatingsServiceProvider::class,
```

Publish vendor files:

```bash
php artisan vendor:publish --tag=public --force
```

## Usage

### Giving a rating

In order to rate a model you need to access [`RatingBuilder`](#API of rating builder) instance.
This can be done in several ways:
* By newing up instance manually:
```php
    $builder = new \Dorvidas\Ratings\RatingBuilder;
    $builder->model($model)->give(5);
```
* Via facade
```php
    Rate::model($model)->give(5);
```
* Via `\Dorvidas\Ratings\RateableTrait` trait method:
```php
    $post->rate()->give(5);
```

#### API of rating builder
* `model($model)` - set what you will give rating for. When using via trait this can be ommited, because we already know the model we will rate.
* `give(5)` - set the rating. The return value is `\Dorvidas\Ratings\Models\Rating` model.
* `by($user)` - set who is rating model. If skipped authorised user is used.
* `on($model)` - this is used to define what a user is rated for.
Speaking in Laravel terminology we define on which model we rate a user. Below example of rating a user for post:
```php
$post = Post::first();
$user = User::first();
$user->rate()->on($post)->give(5);
```
* `as($role)` - this is used to define what was a role of a user.
Speaking in Laravel terminology we define which model's column holds the user ID.
If omitted it is expected that the column is `user_id`.
An real life example could be giving different ratings for post author and illustrator:
```php
$author = User::first();
$illustrator = User::skip(1)->first();
$author->rate()->on($post)->as('author_id')->give(5);
$illustrator()->rate()->on($post)->as('illustrator_id')->give(5);
```

### Getting a ratings

Ratings are retrieved via `\Dorvidas\Ratings\Rating` model.
Model ratings can be retrieved by querying `ratings` relations on a model.
Relations is polymorphic.
Don't forget to add `\Dorvidas\Ratings\MOdels\RateableTrait` for it to work.

#### Rating model fields:

* `model` - name of the rated model.
* `model_id` - ID of rated model.
* `on_model` - this is usually used when we rate a User and want to define what for (on which model) we rate him i.e., on "Post".
* `on_model_id` - ID of the model we rate model. If we rate use on "Post" this would be post ID.
* `on_model_column` - when rating using on model, with this we define what column defines user id. By default this is `user_id`.
* `rated_by` - ID of the user who rated.
* `rating` - actual rating.

#### Rating model query scopes:

* `of` - filter ratings of a model. It filter by `model` and `model_id` columns.
* `on` - filter ratings on specific model. It filter by `on_model` and `on_model_id` columns.
* `as` - filter ratings by role. It filter by `on_model_column` column.
* `model` - filter by `model` column.
* `modelId` - filter by `model_id` column.
* `onModel` - filter by model `on_model` column.
* `onModelId` - filter by `on_model_id` column.

#### Examples

An basic exampe of getting rating list of a "Post":
```php
$post = Post::first();
$ratings = Rating::of($post)->get();
```

If there is no model object, you can pass model ID and model type via scopes `modelId` and `model`:
```php
$postId = 1;
$ratings = Rating::model(Post::class)->modelId($modelId)->get();

//Or doing where statements
$ratings = Rating::where('model', Post::class)->where('model_id, $postId)->get();

```

If we want to get ratings of a user on specific model:
```php
$user = User::first();
$post = Post::first();
$user->ratings()->on($post)->first(); //Returns Rating model instance
$user->ratings()->on($post)->first()->rating; //Returns actual rating
```

If we want to get ratings of a user on specific model for a specific role:
```php
$user = User::first();
$post = Post::first();
$user->ratings()->on($post)->as('author_id')->first();
```

### Getting rating aggregates
Rating aggregates are stored in table `rating_aggregates`. 
If class is using trait `RateableTrait` you can get aggregates by querying polymorphic relationship:
```php
$model->rating_aggregates;
```
Whenever a rating is created an `\Dorvidas\Ratings\Events\RatingCreatedEvent` event is thrown.
There is also a listener `\Dorvidas\Ratings\Listeners\RecalculateRatingAggregatesListener` which updates aggregate entry. 
So don't forget to register those events and listener.

## Config

- `database_prefix` - allows to add database prefix.
