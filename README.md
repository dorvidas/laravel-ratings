# Laravel ratings
Rate users, posts or other models with ease. You can even give a rating to a user for their role on other models i.e., post author or post illustator.

## Installation

You can install this package via composer using this command:

```bash
composer require dorvidas/laravel-ratings:^1.0.0
```

Don't forget to add service provider:
```php
Dorvidas\Ratings\RatingsServiceProvider::class,
```

## Usage

### Giving a rating

In order to rate a model you need to access `RatingBuilder` instance.
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
If omitted it is expected the the column is `user_id`.
An real life example could be giving different ratings for post author and illustrator:
```php
$author = User::first();
$illustrator = User::skip(1)->first();
$author->rate()->on($post)->give(5);
$illustrator()->rate()->on($post)->give(5);
```

### Getting a ratings of model

Ratings are retrieved via `\Dorvidas\Ratings\Rating` model. Rating model fields:

* `model` - name of the rated model.
* `model_id` - ID of rated model.
* `on_model` - this is usually used when we rate a User and want to define what for (on which model) we rate him i.e., on "Post".
* `on_model_id` - ID of the model we rate model. If we rate use on "Post" this would be post ID. 
* `on_model_column` - when rating using on model, with this we define what column defines user id. By default this is `user_id`. 
* `rated_by` - ID of the user who rated. 
* `rating` - actual rating. 

An basic exampe of getting rating list of a "Post":
```php
$post = Post::first();
$ratings = Rating::where('model', Post::class)->where('model_id', $post->id)->get();
```

To make API simpler we can use trait function `ratings`:
```php
$post = Post::first();
$post->ratings()->get();
```

If we want to get ratings of a user on specific model:
```php
$user = User::first();
$post = Post::first();
$user->ratings(Post::class)->get();
```

If we want to get ratings of a user on specific model for a specific role:
```php
$user = User::first();
$post = Post::first();
$user->ratings(Post::class, 'illustrator_id')->get();
```

### Getting rating aggregates
Query builder provides aggregate functions `count`, `max`, `min`, `average`.
So to get average rating of a "Post":
```php
$post = Post::first();
$post->ratings()->avg('rating');
```