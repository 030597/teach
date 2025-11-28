<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Featured tutors (verified and active) - 6 tutors show karenge
        $featuredTutors = User::with('tutorProfile')
            ->where('type', 'tutor')
            ->where('status', 'active')
            ->whereHas('tutorProfile', function($q) {
                $q->where('verification_status', 'verified');
            })
            ->take(6)
            ->get();

        return view('home', compact('featuredTutors'));
    }
}