<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TutorScheduleController;
use App\Http\Controllers\TutorStudentController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tutors', [TutorController::class, 'index'])->name('tutors.index');
Route::get('/tutors/{id}', [TutorController::class, 'show'])->name('tutors.show');

 Route::post('/tutors/{id}/book', [BookingController::class, 'store'])->name('tutors.book');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
// Authentication Routes
Route::get('/register/student', [AuthController::class, 'showStudentRegister'])->name('register.student');
Route::get('/register/tutor', [AuthController::class, 'showTutorRegister'])->name('register.tutor');
Route::get('/register/school', [AuthController::class, 'showSchoolRegister'])->name('register.school');
Route::post('/register/student', [AuthController::class, 'studentRegister']);
Route::post('/register/tutor', [AuthController::class, 'tutorRegister']);
Route::post('/register/school', [AuthController::class, 'schoolRegister']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
  Route::get('/tutor/schedule', [TutorScheduleController::class, 'index'])->name('tutor.schedule')->middleware('tutor');
    Route::post('/tutor/schedule/update', [TutorScheduleController::class, 'update'])->name('tutor.schedule.update')->middleware('tutor');

        Route::get('/tutor/students', [TutorStudentController::class, 'index'])->name('tutor.students');
    Route::get('/tutor/students/{id}', [TutorStudentController::class, 'show'])->name('tutor.students.show');
    // Profile Routes - FIXED
    Route::prefix('profile')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        
        // ADD GET ROUTES FOR PROFILE PAGES
        Route::get('/student', [ProfileController::class, 'showStudentProfile'])->name('profile.student');
        Route::put('/student/update', [ProfileController::class, 'updateStudentProfile'])->name('profile.student.update');
        
        Route::get('/tutor', [ProfileController::class, 'showTutorProfile'])->name('profile.tutor');
        Route::put('/tutor/update', [ProfileController::class, 'updateTutorProfile'])->name('profile.tutor.update');
        
        Route::get('/school', [ProfileController::class, 'showSchoolProfile'])->name('profile.school');
        Route::put('/school/update', [ProfileController::class, 'updateSchoolProfile'])->name('profile.school.update');
        
        Route::get('/verification', [ProfileController::class, 'showIdVerification'])->name('profile.verification');
        Route::post('/verification', [ProfileController::class, 'submitIdVerification'])->name('profile.verification.submit');
    });

    // Dashboard Routes
    Route::get('/dashboard', function () {
        return match(auth()->user()->type) {
            'tutor' => redirect()->route('tutor.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'school' => redirect()->route('school.dashboard'),
            default => redirect()->route('home')
        };
    })->name('dashboard');

    Route::get('/tutor/dashboard', function () {
        return view('dashboard.tutor');
    })->name('tutor.dashboard')->middleware('tutor');

    Route::get('/student/dashboard', function () {
        return view('dashboard.student');
    })->name('student.dashboard')->middleware('student');

    Route::get('/school/dashboard', function () {
        return view('dashboard.school');
    })->name('school.dashboard')->middleware('school');

    Route::get('/tutor/onboarding', function () {
        return view('tutor.onboarding');
    })->name('tutor.onboarding')->middleware('tutor');
});