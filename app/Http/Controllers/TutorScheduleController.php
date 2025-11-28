<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Load existing schedule if available
        $existingSchedule = [];
        if ($user->tutorProfile && $user->tutorProfile->availability_schedule) {
            $existingSchedule = json_decode($user->tutorProfile->availability_schedule, true);
        }
        
        return view('tutor.schedule', compact('user', 'existingSchedule'));
    }
public function update(Request $request)
{
    $user = Auth::user();
    
    \Log::info('=== SCHEDULE UPDATE DEBUG START ===');
    \Log::info('User ID: ' . $user->id);
    \Log::info('Tutor Profile ID: ' . ($user->tutorProfile ? $user->tutorProfile->id : 'NOT FOUND'));

    // Debug raw request data
    \Log::info('RAW REQUEST ALL:', $request->all());
    \Log::info('RAW SCHEDULE DATA:', $request->schedule ?? []);

    $request->validate([
        'schedule' => 'required|array',
    ]);

    // Prepare schedule data with days
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $scheduleData = [];
    
    foreach ($days as $day) {
        $slots = $request->schedule[$day]['slots'] ?? [];
        \Log::info("Day: {$day}, Slots count: " . count($slots));
        
        $scheduleData[$day] = [
            'day' => $day,
            'slots' => $slots
        ];
    }

    $jsonData = json_encode($scheduleData);
    \Log::info('JSON DATA TO SAVE: ' . $jsonData);

    try {
        // METHOD 1: Direct DB update
        \Log::info('Attempting DIRECT DB update...');
        $affected = \DB::table('tutor_profiles')
            ->where('id', $user->tutorProfile->id)
            ->update(['availability_schedule' => $jsonData]);
            
        \Log::info('DIRECT DB - Rows affected: ' . $affected);

        // METHOD 2: Eloquent update
        \Log::info('Attempting ELOQUENT update...');
        $user->tutorProfile->availability_schedule = $jsonData;
        $eloquentSaved = $user->tutorProfile->save();
        \Log::info('ELOQUENT - Save result: ' . ($eloquentSaved ? 'SUCCESS' : 'FAILED'));

        // METHOD 3: Fresh query to verify
        \Log::info('Verifying with fresh query...');
        $freshData = \DB::table('tutor_profiles')
            ->where('id', $user->tutorProfile->id)
            ->value('availability_schedule');
        \Log::info('FRESH QUERY RESULT: ' . ($freshData ?? 'NULL'));

        \Log::info('=== SCHEDULE UPDATE DEBUG END ===');

        if ($affected > 0 || $eloquentSaved) {
            return redirect()->back()->with('success', 'Schedule updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to save schedule. No rows affected.');
        }
        
    } catch (\Exception $e) {
        \Log::error('EXCEPTION: ' . $e->getMessage());
        \Log::error('TRACE: ' . $e->getTraceAsString());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
}