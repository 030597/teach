<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class BookingController extends Controller
{
    public function store(Request $request, $tutorId)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'scheduled_time' => 'required|date|after:now',
            'duration' => 'required|in:30,60,90,120',
            'notes' => 'nullable|string'
        ]);

        $tutor = User::where('type', 'tutor')->findOrFail($tutorId);
        $hourlyRate = $tutor->tutorProfile->hourly_rate;
        $amount = ($hourlyRate * $request->duration) / 60;

        $booking = Booking::create([
            'tutor_id' => $tutorId,
            'student_id' => auth()->id(),
            'subject' => $request->subject,
            'notes' => $request->notes,
            'scheduled_time' => $request->scheduled_time,
            'duration' => $request->duration,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking request sent successfully! The tutor will confirm soon.');
    }

    public function index()
    {
        $bookings = Booking::with('tutor')
            ->where('student_id', auth()->id())
            ->orderBy('scheduled_time', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }
}