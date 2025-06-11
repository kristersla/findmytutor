<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tutorProfiles()
    {
        return $this->belongsToMany(TutorProfile::class, 'subject_tutor_profile');
    }
}
