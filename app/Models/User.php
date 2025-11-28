<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone',
        'avatar',
        'status',
        'bio',
        'timezone'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
        // Add School Profile Relationship
    public function schoolProfile()
    {
        return $this->hasOne(SchoolProfile::class);
    }

    // Update Scopes
    public function scopeSchools($query)
    {
        return $query->where('type', 'school');
    }

    // Update Methods
    public function isSchool()
    {
        return $this->type === 'school';
    }
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function tutorProfile()
    {
        return $this->hasOne(TutorProfile::class);
    }

    public function idVerification()
    {
        return $this->hasOne(IdVerification::class);
    }

    public function trainingProgress()
    {
        return $this->hasMany(TutorTrainingProgress::class, 'tutor_id');
    }

    // Scopes
    public function scopeTutors($query)
    {
        return $query->where('type', 'tutor');
    }

    public function scopeStudents($query)
    {
        return $query->where('type', 'student');
    }

    // public function scopeSchools($query)
    // {
    //     return $query->where('type', 'school');
    // }


public function getProfileCompletion()
{
    $totalItems = 0;
    $completedItems = 0;
    $completion = [];

    // 1. Basic Information
    $totalItems++;
    $basicInfo = !empty($this->name) && !empty($this->email) && !empty($this->phone);
    if ($basicInfo) $completedItems++;
    $completion['basic_info'] = $basicInfo;

    // 2. Subjects Added (for tutors)
    $totalItems++;
    $subjectsAdded = false;
    if ($this->isTutor() && $this->tutorProfile) {
        $subjects = $this->tutorProfile->subjects;
        if (is_string($subjects)) {
            $subjects = json_decode($subjects, true);
        }
        $subjectsAdded = !empty($subjects);
    }
    if ($subjectsAdded) $completedItems++;
    $completion['subjects_added'] = $subjectsAdded;

    // 3. ID Verification
    $totalItems++;
    $idVerified = $this->idVerification && in_array($this->idVerification->status, ['pending', 'verified']);
    if ($idVerified) $completedItems++;
    $completion['id_verified'] = $idVerified;
    $completion['id_status'] = $this->idVerification ? $this->idVerification->status : 'not_submitted';


    // 4. Training Completed
    $totalItems++;
    $trainingCompleted = false; // Placeholder
    if ($trainingCompleted) $completedItems++;
    $completion['training_completed'] = $trainingCompleted;

    // 5. Availability Set
  // 5. Availability Set - FIXED LOGIC
    $totalItems++;
    $availabilitySet = false;
    if ($this->isTutor() && $this->tutorProfile && $this->tutorProfile->availability_schedule) {
        $schedule = json_decode($this->tutorProfile->availability_schedule, true);
        // Check if any day has at least one slot
        foreach ($schedule as $dayData) {
            if (!empty($dayData['slots']) && is_array($dayData['slots']) && count($dayData['slots']) > 0) {
                $availabilitySet = true;
                break;
            }
        }
    }
    if ($availabilitySet) $completedItems++;
    $completion['availability_set'] = $availabilitySet;


    // 6. Profile Photo
    $totalItems++;
    $profilePhoto = !empty($this->avatar);
    if ($profilePhoto) $completedItems++;
    $completion['profile_photo'] = $profilePhoto;

    // Calculate percentage
    $percentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
    $completion['percentage'] = $percentage;
    $completion['completed_items'] = $completedItems;
    $completion['total_items'] = $totalItems;

    return $completion;
}

public function bookings()
{
    return $this->hasMany(Booking::class, 'student_id');
}
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->whereHas('tutorProfile', function($q) {
            $q->where('verification_status', 'verified');
        });
    }

    // Methods
    public function isTutor()
    {
        return $this->type === 'tutor';
    }

    public function isStudent()
    {
        return $this->type === 'student';
    }

    // public function isSchool()
    // {
    //     return $this->type === 'school';
    // }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    public function hasCompletedTraining()
    {
        if (!$this->isTutor()) return false;

        $totalModules = TrainingModule::where('is_active', true)->count();
        $completedModules = $this->trainingProgress()->where('is_completed', true)->count();

        return $totalModules > 0 && $completedModules === $totalModules;
    }
}