<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TutorProfile;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('tutorProfile')
            ->where('type', 'tutor')
            ->where('status', 'active')
            ->whereHas('tutorProfile', function($q) {
                $q->where('verification_status', 'verified');
            });

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('tutorProfile', function($q2) use ($search) {
                      $q2->where('headline', 'like', "%{$search}%")
                         ->orWhere('subjects', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by subject
        if ($request->has('subject') && $request->subject) {
            $query->whereHas('tutorProfile', function($q) use ($request) {
                $q->where('subjects', 'like', "%{$request->subject}%");
            });
        }

        $tutors = $query->paginate(12);

        $popularSubjects = [
            'Mathematics', 'Science', 'English', 'Programming',
            'Physics', 'Chemistry', 'Biology', 'Business Studies'
        ];

        return view('tutors.index', compact('tutors', 'popularSubjects'));
    }

    public function show($id)
    {
        $tutor = User::with('tutorProfile')
            ->where('type', 'tutor')
            ->where('status', 'active')
            ->whereHas('tutorProfile', function($q) {
                $q->where('verification_status', 'verified');
            })
            ->findOrFail($id);

        return view('tutors.show', compact('tutor'));
    }
}