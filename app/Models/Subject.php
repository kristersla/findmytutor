<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TutorProfile;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tutorProfiles()
    {
        return $this->hasMany(TutorProfile::class);
    }
}
