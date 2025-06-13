<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions';
    protected $primaryKey = 'session_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tutor_profile_id',
        'student_user_id',
        'datetime',
        'duration',
        'status',
        'notes'
    ];

    public function tutorProfile()
    {
        return $this->belongsTo(TutorProfile::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }

    public function tutor()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            \App\Models\TutorProfile::class,
            'id',
            'id',
            'tutor_profile_id',
            'user_id'
        );
    }

    public function cancel(Session $session)
    {
        if ($session->student_user_id !== auth()->id()) {
            abort(403);
        }

        $session->update(['status' => 'cancelled']);

        return redirect()->route('sessions.dashboard')->with('success', 'Session cancelled.');
    }

}
