<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_name',
        'registration_number',
        'address',
        'city',
        'country',
        'website',
        'total_students',
        'total_teachers',
        'grades_offered',
        'facilities',
        'institution_type'
    ];

    protected $casts = [
        'grades_offered' => 'array',
        'facilities' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}