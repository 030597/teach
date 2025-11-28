<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorTrainingProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'training_module_id',
        'is_completed',
        'score',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function trainingModule()
    {
        return $this->belongsTo(TrainingModule::class);
    }
}