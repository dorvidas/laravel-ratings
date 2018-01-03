<?php

namespace Dorvidas\Ratings\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Dorvidas\Ratings\Models\RateableTrait;

class Post extends Model
{
    use RateableTrait;
}