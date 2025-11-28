<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TutorProfile;
use App\Models\IdVerification;
use App\Models\SchoolProfile; // ADD THIS

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showStudentRegister()
    {
        return view('auth.student-register');
    }

    public function showTutorRegister()
    {
        return view('auth.tutor-register');
    }

   public function studentRegister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'required|string|max:20',
        'education_level' => 'required|string',
        'school_name' => 'nullable|string|max:255',
        'learning_goals' => 'nullable|string',
        'parent_name' => 'nullable|string|max:255',
        'parent_email' => 'nullable|email',
        'parent_phone' => 'nullable|string|max:20',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'type' => 'student',
        'status' => 'active'
    ]);

    StudentProfile::create([
        'user_id' => $user->id,
        'education_level' => $request->education_level,
        'school_name' => $request->school_name,
        'learning_goals' => $request->learning_goals,
        'preferred_subjects' => $request->preferred_subjects ? json_encode($request->preferred_subjects) : null,
        'parent_name' => $request->parent_name,
        'parent_email' => $request->parent_email,
        'parent_phone' => $request->parent_phone,
    ]);

    auth()->login($user);

    return redirect()->route('student.dashboard')->with('success', 'Student account created successfully!');
}
    public function tutorRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'headline' => 'required|string|max:255',
            'subjects' => 'required|array',
            'hourly_rate' => 'required|numeric|min:0',
            'teaching_mode' => 'required|in:online,offline,both',
            'experience_years' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'type' => 'tutor',
            'status' => 'pending'
        ]);

        TutorProfile::create([
            'user_id' => $user->id,
            'headline' => $request->headline,
            'subjects' => json_encode($request->subjects),
            'hourly_rate' => $request->hourly_rate,
            'teaching_mode' => $request->teaching_mode,
            'experience_years' => $request->experience_years,
            'education' => $request->education ? json_encode($request->education) : null,
            'experience' => $request->experience ? json_encode($request->experience) : null,
        ]);

        auth()->login($user);

        return redirect()->route('tutor.onboarding')->with('success', 'Tutor account created successfully! Complete your profile verification.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }
  // UPDATE LOGIN METHOD
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (auth()->attempt($request->only('email', 'password'), $request->remember)) {
            $user = auth()->user();
            
            if ($user->status === 'suspended') {
                auth()->logout();
                return redirect()->back()->with('error', 'Your account has been suspended.');
            }

            $request->session()->regenerate();

            return match($user->type) {
                'tutor' => redirect()->route('tutor.dashboard'),
                'student' => redirect()->route('student.dashboard'),
                'school' => redirect()->route('school.dashboard'),
                default => redirect()->route('home')
            };
        }

        return redirect()->back()->with('error', 'Invalid credentials provided.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }









  public function showSchoolRegister()
    {
        return view('auth.school-register');
    }

    public function schoolRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'institution_type' => 'required|in:school,college,university,coaching_center',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'type' => 'school',
            'status' => 'pending'
        ]);

        SchoolProfile::create([
            'user_id' => $user->id,
            'school_name' => $request->school_name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'institution_type' => $request->institution_type,
            'website' => $request->website,
            'registration_number' => $request->registration_number,
        ]);

        auth()->login($user);

        return redirect()->route('school.dashboard')->with('success', 'School account created successfully!');
    }

  






}