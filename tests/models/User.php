<?php

namespace Dorvidas\Ratings\Tests\Models;
use Dorvidas\Ratings\Models\RateableTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use RateableTrait;
}
