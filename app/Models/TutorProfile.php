<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'headline',
        'education',
        'experience',
        'subjects',
        'hourly_rate',
        'teaching_mode',
        'location',
        'video_intro',
        'availability_schedule',
        'experience_years',
        'verification_status',
        'verification_notes',
        'is_certified'
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'subjects' => 'array',
        'hourly_rate' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEducationArrayAttribute()
    {
        return $this->education ?? [];
    }

    public function getExperienceArrayAttribute()
    {
        return $this->experience ?? [];
    }

    public function getSubjectsArrayAttribute()
    {
        return $this->subjects ?? [];
    }

    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }
}