@extends('layouts.app')

@section('title', 'Tutor Dashboard - LearnWithExperts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                  

                     <img src="{{ auth()->user()->avatar ? asset('images/avatars/' . auth()->user()->avatar) : asset('images/avatars/avatar.png') }}" alt="Avatar" class="rounded-circl mb-3" width="100" height="100">
                    <h5>{{ auth()->user()->name }}</h5>
                    <p class="text-muted">Tutor</p>
                    
                    @if(auth()->user()->tutorProfile->verification_status === 'pending')
                        <div class="alert alert-warning small mb-2">
                            <i class="fas fa-clock me-1"></i>Profile under review
                        </div>
                    @elseif(auth()->user()->tutorProfile->verification_status === 'verified')
                        <div class="alert alert-success small mb-2">
                            <i class="fas fa-check-circle me-1"></i>Profile verified
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                        @if(!auth()->user()->tutorProfile->is_certified)
                            <a href="{{ route('tutor.onboarding') }}" class="btn btn-outline-success btn-sm">Complete Training</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tutor.schedule') }}" class="btn btn-outline-primary btn-sm">Manage Schedule</a>
                        <a href="{{ route('tutor.students') }}" class="btn btn-outline-success btn-sm">My Students</a>
                        <a href="/tutor/earnings" class="btn btn-outline-info btn-sm">Earnings</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Total Students</h6>
                                    <h3>0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Completed</h6>
                                    <h3>0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Upcoming</h6>
                                    <h3>0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Earnings</h6>
                                    <h3>$0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Completion -->
    <div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Profile Completion</h5>
    </div>
    <div class="card-body">
        @php
            $completion = auth()->user()->getProfileCompletion();
        @endphp
        
        <div class="progress mb-3" style="height: 20px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $completion['percentage'] }}%;" 
                 aria-valuenow="{{ $completion['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                {{ $completion['percentage'] }}%
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li>
                        <i class="fas {{ $completion['basic_info'] ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                        Basic Information
                        @if(!$completion['basic_info'])
                            <a href="{{ route('profile.edit') }}" class="small ms-2">Complete</a>
                        @endif
                    </li>
                    <li>
                        <i class="fas {{ $completion['subjects_added'] ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                        Subjects Added
                        @if(!$completion['subjects_added'])
                            <a href="{{ route('profile.tutor') }}" class="small ms-2">Add</a>
                        @endif
                    </li>
                    <li>
                        <i class="fas {{ $completion['id_verified'] ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                        ID Verification
                        @if(!$completion['id_verified'])
                            <a href="{{ route('profile.verification') }}" class="small ms-2">Verify</a>
                        @endif
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li>
                        <i class="fas {{ $completion['training_completed'] ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                        Training Completed
                        @if(!$completion['training_completed'])
                            <span class="small ms-2 text-muted">Coming Soon</span>
                        @endif
                    </li>
     
<li>
    <i class="fas {{ $completion['availability_set'] ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
    Availability Set
    @if(!$completion['availability_set'])
        <a href="{{ route('tutor.schedule') }}" class="small ms-2">Set</a>
    @endif
</li>
                    <li>
                        <i class="fas {{ $completion['profile_photo'] ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                        Profile Photo
                        @if(!$completion['profile_photo'])
                            <a href="{{ route('profile.edit') }}" class="small ms-2">Upload</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        
        @if($completion['percentage'] < 100)
            <div class="alert alert-info mt-3">
                <small>
                    <i class="fas fa-info-circle me-1"></i>
                    Complete your profile to increase your visibility and get more students.
                    <a href="{{ route('profile.tutor') }}" class="alert-link">Complete now</a>
                </small>
            </div>
        @else
            <div class="alert alert-success mt-3">
                <small>
                    <i class="fas fa-check-circle me-1"></i>
                    Your profile is 100% complete! You're now visible to students.
                </small>
            </div>
        @endif
    </div>
</div>

            <!-- Recent Bookings -->
                <!-- Recent Bookings -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Bookings</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No upcoming bookings</h5>
                        <p class="text-muted">Students will see your profile once it's fully set up</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Complete Profile</a>
                    </div>
                </div>
            </div>

            <!-- Your Available Time Slots - ADD THIS SECTION -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Your Available Time Slots</h5>
                </div>
                <div class="card-body">
                    @php
                        $user = auth()->user();
                        $availableSlots = [];
                        $totalSlots = 0;
                        
                        if ($user->tutorProfile && $user->tutorProfile->availability_schedule) {
                            $schedule = json_decode($user->tutorProfile->availability_schedule, true);
                            foreach ($schedule as $dayData) {
                                if (!empty($dayData['slots']) && is_array($dayData['slots'])) {
                                    $availableSlots[$dayData['day']] = $dayData['slots'];
                                    $totalSlots += count($dayData['slots']);
                                }
                            }
                        }
                    @endphp
                    
                    @if($totalSlots > 0)
                        <div class="row">
                            @foreach($availableSlots as $day => $slots)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <h6 class="text-primary">
                                                <i class="fas fa-calendar-day me-2"></i>
                                                {{ ucfirst($day) }}
                                                <span class="badge bg-primary float-end">{{ count($slots) }}</span>
                                            </h6>
                                            <div class="mt-2">
                                                @foreach($slots as $slot)
                                                    <span class="badge bg-success me-1 mb-1">{{ $slot }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Total {{ $totalSlots }} available slots across {{ count($availableSlots) }} days
                            </p>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Available Slots</h5>
                            <p class="text-muted">You haven't set your availability schedule yet.</p>
                            <a href="{{ route('tutor.schedule') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-plus me-2"></i>Set Your Schedule
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection