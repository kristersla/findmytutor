<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;
    protected $fillable = ['tutor_profile_id', 'day_of_week', 'start_time', 'end_time'];

    public function tutorProfile()
    {
        return $this->belongsTo(TutorProfile::class);
    }
}

