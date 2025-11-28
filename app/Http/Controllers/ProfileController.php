<?php

namespace App\Http\Controllers;
use Intervention\Image\ImageManagerStatic as Image; 

use App\Models\User;
use App\Models\IdVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; 


class ProfileController extends Controller
{
   public function edit()
{
    $user = auth()->user();
    return view('profile.edit', compact('user')); // Sab users ke liye same page
}


   public function showStudentProfile()
    {
        $user = auth()->user();
        return view('profile.student-edit', compact('user'));
    }
    public function showTutorProfile()
    {
        $user = auth()->user();
        return view('profile.tutor-edit', compact('user'));
    }

    public function showSchoolProfile()
    {
        $user = auth()->user();
        return view('profile.school-edit', compact('user'));
    }

public function update(Request $request)
{
    $user = auth()->user();

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required|string|max:20',
        'bio' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp', // no size limit
        'timezone' => 'required|string',
         'current_password' => 'nullable|required_with:new_password',
        'new_password' => 'nullable|confirmed'
    ];

    $request->validate($rules);

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $extension = $avatar->getClientOriginalExtension(); // keep original extension
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $extension;

        // Move file directly to public folder
        $avatar->move(public_path('images/avatars'), $filename);

        // Delete old avatar if exists
        if ($user->avatar && file_exists(public_path('images/avatars/' . $user->avatar))) {
            unlink(public_path('images/avatars/' . $user->avatar));
        }

        $user->avatar = $filename;
    }

    $user->update($request->only(['name', 'email', 'phone', 'bio', 'timezone']));

     // Update basic info

    // Handle password change
    if ($request->filled('current_password') && $request->filled('new_password')) {
        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
    }

    return redirect()->back()->with('success', 'Profile updated successfully.');
}



    public function updateTutorProfile(Request $request)
    {
        $user = auth()->user();
        $tutorProfile = $user->tutorProfile;

        $request->validate([
            'headline' => 'required|string|max:255',
            'subjects' => 'required|array',
            'hourly_rate' => 'required|numeric|min:0',
            'teaching_mode' => 'required|in:online,offline,both',
            'location' => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'education' => 'nullable|array',
            'experience' => 'nullable|array',
        ]);

        $tutorProfile->update([
            'headline' => $request->headline,
            'subjects' => json_encode($request->subjects),
            'hourly_rate' => $request->hourly_rate,
            'teaching_mode' => $request->teaching_mode,
            'location' => $request->location,
            'experience_years' => $request->experience_years,
            'education' => $request->education ? json_encode($request->education) : null,
            'experience' => $request->experience ? json_encode($request->experience) : null,
        ]);

        return redirect()->back()->with('success', 'Tutor profile updated successfully.');
    }

    public function showIdVerification()
    {
        $user = auth()->user();
        $verification = $user->idVerification;

        return view('profile.id-verification', compact('user', 'verification'));
    }

    public function submitIdVerification(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'document_type' => 'required|in:cnic,passport,license',
            'document_number' => 'required|string|max:50',
            'front_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'selfie_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Handle file uploads with optimization
        $frontImage = $this->optimizeAndStoreImage($request->file('front_image'), 'verifications');
        $backImage = $request->hasFile('back_image') ? $this->optimizeAndStoreImage($request->file('back_image'), 'verifications') : null;
        $selfieImage = $this->optimizeAndStoreImage($request->file('selfie_image'), 'verifications');

        IdVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'front_image' => $frontImage,
                'back_image' => $backImage,
                'selfie_image' => $selfieImage,
                'status' => 'pending'
            ]
        );

        return redirect()->back()->with('success', 'ID verification submitted successfully. We will review your documents.');
    }
private function optimizeAndStoreImage($file, $folder)
{
    // Original extension
    $extension = $file->getClientOriginalExtension();

    // Filename with same extension (no convert)
    $filename = $folder . '_' . uniqid() . '.' . $extension;

    // Public folder path
    $publicPath = public_path('images/' . $folder);

    // Create directory if not exists
    if (!file_exists($publicPath)) {
        mkdir($publicPath, 0755, true);
    }

    // Move original file (no compression, no conversion)
    $file->move($publicPath, $filename);

    return $filename;
}


  public function updateStudentProfile(Request $request)
    {
        $user = auth()->user();
        
        // Ensure user has student profile
        if (!$user->studentProfile) {
            StudentProfile::create(['user_id' => $user->id]);
        }

        $request->validate([
            'education_level' => 'required|in:primary,secondary,high_school,undergraduate,graduate',
            'school_name' => 'nullable|string|max:255',
            'learning_goals' => 'nullable|string',
            'parent_name' => 'nullable|string|max:255',
            'parent_email' => 'nullable|email',
            'parent_phone' => 'nullable|string|max:20',
        ]);

        $user->studentProfile->update([
            'education_level' => $request->education_level,
            'school_name' => $request->school_name,
            'learning_goals' => $request->learning_goals,
            'parent_name' => $request->parent_name,
            'parent_email' => $request->parent_email,
            'parent_phone' => $request->parent_phone,
            'preferred_subjects' => $request->preferred_subjects ? json_encode($request->preferred_subjects) : null,
        ]);

        return redirect()->back()->with('success', 'Student profile updated successfully.');
    }

        // ADD SCHOOL PROFILE UPDATE METHOD
    public function updateSchoolProfile(Request $request)
    {
        $user = auth()->user();
        $schoolProfile = $user->schoolProfile;

        $request->validate([
            'school_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'website' => 'nullable|url',
            'total_students' => 'nullable|integer|min:0',
            'total_teachers' => 'nullable|integer|min:0',
            'institution_type' => 'required|in:school,college,university,coaching_center',
        ]);

        $schoolProfile->update([
            'school_name' => $request->school_name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'website' => $request->website,
            'total_students' => $request->total_students,
            'total_teachers' => $request->total_teachers,
            'institution_type' => $request->institution_type,
            'grades_offered' => $request->grades_offered ? json_encode($request->grades_offered) : null,
            'facilities' => $request->facilities ? json_encode($request->facilities) : null,
        ]);

        return redirect()->back()->with('success', 'School profile updated successfully.');
    }
}