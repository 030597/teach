@extends('layouts.app')

@section('title', $student->name . ' - Student Details')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Student Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $student->avatar_url }}" alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                    <h4>{{ $student->name }}</h4>
                    <p class="text-muted">{{ $student->email }}</p>
                    <p class="text-muted">
                        <i class="fas fa-phone"></i> {{ $student->phone ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Learning Goals -->
            @if($student->studentProfile && $student->studentProfile->learning_goals)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Learning Goals</h6>
                </div>
                <div class="card-body">
                    <p>{{ $student->studentProfile->learning_goals }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-8">
            <!-- Student Details -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Education Level:</strong>
                            <p>{{ $student->studentProfile->education_level ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>School Name:</strong>
                            <p>{{ $student->studentProfile->school_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Preferred Subjects:</strong>
                            <div class="mt-2">
                                @if($student->studentProfile && $student->studentProfile->preferred_subjects)
                                    @foreach(json_decode($student->studentProfile->preferred_subjects) as $subject)
                                        <span class="badge bg-primary me-1 mb-1">{{ $subject }}</span>
                                    @endforeach
                                @else
                                    <p class="text-muted">N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information -->
                    @if($student->studentProfile && ($student->studentProfile->parent_name || $student->studentProfile->parent_email))
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Parent/Guardian Information</h6>
                            <div class="row">
                                @if($student->studentProfile->parent_name)
                                <div class="col-md-6">
                                    <strong>Name:</strong>
                                    <p>{{ $student->studentProfile->parent_name }}</p>
                                </div>
                                @endif
                                @if($student->studentProfile->parent_email)
                                <div class="col-md-6">
                                    <strong>Email:</strong>
                                    <p>{{ $student->studentProfile->parent_email }}</p>
                                </div>
                                @endif
                                @if($student->studentProfile->parent_phone)
                                <div class="col-md-6">
                                    <strong>Phone:</strong>
                                    <p>{{ $student->studentProfile->parent_phone }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Session History -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Session History</h5>
                </div>
                <div class="card-body">
                    @php
                        $bookings = \App\Models\Booking::where('tutor_id', auth()->id())
                            ->where('student_id', $student->id)
                            ->orderBy('scheduled_time', 'desc')
                            ->get();
                    @endphp

                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Subject</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($booking->scheduled_time)->format('M j, Y g:i A') }}</td>
                                        <td>{{ $booking->subject }}</td>
                                        <td>{{ $booking->duration }} minutes</td>
                                        <td>
                                            <span class="badge 
                                                @if($booking->status == 'completed') bg-success
                                                @elseif($booking->status == 'confirmed') bg-primary
                                                @elseif($booking->status == 'pending') bg-warning
                                                @else bg-secondary @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No session history found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection