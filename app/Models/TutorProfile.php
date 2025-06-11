<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'bio', 'availability', 'location', 'contact_method', 'subject_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_tutors');
    }

    public function sessions()
    {
        return $this->hasMany(\App\Models\Session::class, 'tutor_profile_id');
    }


}
