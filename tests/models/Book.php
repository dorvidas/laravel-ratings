<?php

namespace Dorvidas\Ratings\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Dorvidas\Ratings\Models\RateableTrait;

class Book extends Model
{
    use RateableTrait;
}