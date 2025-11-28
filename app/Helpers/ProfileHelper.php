<?php

namespace App\Helpers;

use App\Models\User;

class ProfileHelper
{
    public static function calculateProfileCompletion(User $user)
    {
        $totalItems = 0;
        $completedItems = 0;
        $completion = [];

        // 1. Basic Information
        $totalItems++;
        $basicInfo = !empty($user->name) && !empty($user->email) && !empty($user->phone);
        if ($basicInfo) $completedItems++;
        $completion['basic_info'] = $basicInfo;

        // 2. Subjects Added (for tutors)
        $totalItems++;
        $subjectsAdded = false;
        if ($user->isTutor() && $user->tutorProfile) {
            $subjects = $user->tutorProfile->subjects;
            if (is_string($subjects)) {
                $subjects = json_decode($subjects, true);
            }
            $subjectsAdded = !empty($subjects);
        }
        if ($subjectsAdded) $completedItems++;
        $completion['subjects_added'] = $subjectsAdded;

        // 3. ID Verification
        $totalItems++;
        $idVerified = $user->idVerification && $user->idVerification->status === 'verified';
        if ($idVerified) $completedItems++;
        $completion['id_verified'] = $idVerified;

        // 4. Training Completed
        $totalItems++;
        $trainingCompleted = false; // Placeholder for training module
        if ($trainingCompleted) $completedItems++;
        $completion['training_completed'] = $trainingCompleted;

        // 5. Availability Set
        $totalItems++;
        $availabilitySet = false; // Placeholder for availability
        if ($availabilitySet) $completedItems++;
        $completion['availability_set'] = $availabilitySet;

        // 6. Profile Photo
        $totalItems++;
        $profilePhoto = !empty($user->avatar);
        if ($profilePhoto) $completedItems++;
        $completion['profile_photo'] = $profilePhoto;

        // Calculate percentage
        $percentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
        $completion['percentage'] = $percentage;
        $completion['completed_items'] = $completedItems;
        $completion['total_items'] = $totalItems;

        return $completion;
    }
}