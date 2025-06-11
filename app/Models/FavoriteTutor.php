<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FavoriteTutor extends Pivot
{
    protected $table = 'favorite_tutors';

    protected $fillable = ['user_id', 'tutor_profile_id'];
}

