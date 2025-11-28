<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'content',
        'duration_minutes',
        'order',
        'is_active'
    ];

    public function tutorProgress()
    {
        return $this->hasMany(TutorTrainingProgress::class);
    }
}