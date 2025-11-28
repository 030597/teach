<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'education_level',
        'school_name',
        'learning_goals',
        'preferred_subjects',
        'parent_name',
        'parent_email',
        'parent_phone'
    ];

    protected $casts = [
        'preferred_subjects' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}