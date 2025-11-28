<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\StudentProfile;

class TutorStudentController extends Controller
{
    public function index()
    {
        // Tutor ke saath booked students get karen
        $tutorId = auth()->id();
        
        $students = User::whereHas('bookings', function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId)
                  ->whereIn('status', ['confirmed', 'completed']);
        })
        ->with(['studentProfile', 'bookings' => function($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        }])
        ->get();

        return view('tutor.students.index', compact('students'));
    }

    public function show($id)
    {
        $student = User::with('studentProfile')
                      ->where('id', $id)
                      ->where('type', 'student')
                      ->firstOrFail();

        // Verify that this student has bookings with current tutor
        $hasBookings = Booking::where('tutor_id', auth()->id())
                             ->where('student_id', $id)
                             ->exists();

        if (!$hasBookings) {
            abort(404);
        }

        return view('tutor.students.show', compact('student'));
    }
}