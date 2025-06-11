<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = ['name', 'email', 'password', 'google_id'];

    public function tutorProfile()
    {
        return $this->hasOne(TutorProfile::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_user_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_user_id');
    }

    public function favoriteTutors()
    {
        return $this->belongsToMany(TutorProfile::class, 'favorite_tutors');
    }

    public function sessionsAsStudent()
    {
        return $this->hasMany(\App\Models\Session::class, 'student_user_id');
    }

    public function tutorSessions()
    {
        return $this->hasManyThrough(
            \App\Models\Session::class,
            \App\Models\TutorProfile::class,
            'user_id',
            'tutor_profile_id',
            'id',
            'id'
        );
    }
}
