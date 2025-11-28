@extends('layouts.app')

@section('title', 'Tutor Onboarding - LearnWithExperts')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Welcome to LearnWithExperts!</h2>
                    <p class="mb-0 mt-2">Complete your tutor profile to start teaching</p>
                </div>
                <div class="card-body p-5">
                    
                    @php
                        $user = auth()->user();
                        $completion = $user->getProfileCompletion();
                        
                        // Calculate progress
                        $stepsCompleted = 0;
                        if ($completion['basic_info']) $stepsCompleted++;
                        if ($completion['subjects_added']) $stepsCompleted++;
                        if ($completion['id_verified']) $stepsCompleted++;
                        $progressPercentage = ($stepsCompleted / 3) * 100; // 3 main steps
                    @endphp

                    <!-- Progress Steps - Dynamic -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="text-center">
                                    <div class="rounded-circle {{ $completion['basic_info'] ? 'bg-success' : 'bg-primary' }} text-white d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                        @if($completion['basic_info']) <i class="fas fa-check"></i> @else 1 @endif
                                    </div>
                                    <div class="small">Basic Info</div>
                                </div>
                                <div class="text-center">
                                    <div class="rounded-circle {{ $completion['subjects_added'] ? 'bg-success' : ($completion['basic_info'] ? 'bg-primary' : 'bg-secondary') }} text-white d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                        @if($completion['subjects_added']) <i class="fas fa-check"></i> @else 2 @endif
                                    </div>
                                    <div class="small">Profile Setup</div>
                                </div>
                                <div class="text-center">
                                    <div class="rounded-circle {{ $completion['id_verified'] ? 'bg-success' : (($completion['basic_info'] && $completion['subjects_added']) ? 'bg-primary' : 'bg-secondary') }} text-white d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                        @if($completion['id_verified']) <i class="fas fa-check"></i> @else 3 @endif
                                    </div>
                                    <div class="small">Verification</div>
                                </div>
                                <div class="text-center">
                                    <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">4</div>
                                    <div class="small">Training</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-4">Complete Your Tutor Profile</h4>
                            <p class="text-muted mb-4">To start receiving students, please complete the following steps:</p>

                            <!-- Steps List - Dynamic -->
                            <div class="list-group mb-4">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas {{ $completion['basic_info'] ? 'fa-check text-success' : 'fa-user-check text-warning' }} me-2"></i>
                                        <strong>Basic Information</strong>
                                        <p class="mb-0 small text-muted">Complete your personal details</p>
                                    </div>
                                    @if($completion['basic_info'])
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Complete</a>
                                    @endif
                                </div>

                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas {{ $completion['subjects_added'] ? 'fa-check text-success' : 'fa-chalkboard-teacher text-warning' }} me-2"></i>
                                        <strong>Tutor Profile</strong>
                                        <p class="mb-0 small text-muted">Add your teaching details and subjects</p>
                                    </div>
                                    @if($completion['subjects_added'])
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <a href="{{ route('profile.tutor') }}" class="btn btn-outline-primary btn-sm">Setup</a>
                                    @endif
                                </div>

                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas {{ $completion['id_verified'] ? 'fa-check text-success' : 'fa-id-card text-warning' }} me-2"></i>
                                        <strong>ID Verification</strong>
                                        <p class="mb-0 small text-muted">Verify your identity to build trust</p>
                                    </div>
                                    @if($completion['id_verified'])
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <a href="{{ route('profile.verification') }}" class="btn btn-outline-primary btn-sm">Verify</a>
                                    @endif
                                </div>

                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-graduation-cap text-warning me-2"></i>
                                        <strong>Training Modules</strong>
                                        <p class="mb-0 small text-muted">Complete tutor training (Coming Soon)</p>
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm" disabled>Start</button>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary mb-1">0</h3>
                                            <p class="small text-muted mb-0">Students</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary mb-1">$0</h3>
                                            <p class="small text-muted mb-0">Earnings</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary mb-1">0</h3>
                                            <p class="small text-muted mb-0">Reviews</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                                    <h5>Ready to Start?</h5>
                                    <p class="small text-muted mb-3">Complete your profile to appear in tutor searches</p>
                                    
                                    @if($progressPercentage == 100)
                                        <div class="alert alert-success small">
                                            <i class="fas fa-check me-1"></i>
                                            Profile Complete!
                                        </div>
                                    @elseif(auth()->user()->tutorProfile && auth()->user()->tutorProfile->verification_status === 'verified')
                                        <div class="alert alert-success small">
                                            <i class="fas fa-check me-1"></i>
                                            Profile Verified
                                        </div>
                                    @else
                                        <div class="alert alert-warning small">
                                            <i class="fas fa-clock me-1"></i>
                                            Profile Under Review
                                        </div>
                                    @endif

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('tutor.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                                        @if($progressPercentage < 100)
                                            <a href="{{ route('profile.tutor') }}" class="btn btn-outline-primary">Complete Profile</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Tips Section -->
                            <div class="card border-0 mt-4">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0"><i class="fas fa-lightbulb me-2 text-warning"></i>Quick Tips</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled small">
                                        <li class="mb-2"><i class="fas {{ $progressPercentage == 100 ? 'fa-check text-success' : 'fa-check text-muted' }} me-2"></i>Complete all profile sections</li>
                                        <li class="mb-2"><i class="fas {{ $completion['profile_photo'] ? 'fa-check text-success' : 'fa-check text-muted' }} me-2"></i>Add a professional profile photo</li>
                                        <li class="mb-2"><i class="fas {{ $user->tutorProfile && $user->tutorProfile->hourly_rate > 0 ? 'fa-check text-success' : 'fa-check text-muted' }} me-2"></i>Set competitive hourly rates</li>
                                        <li class="mb-2"><i class="fas {{ $completion['id_verified'] ? 'fa-check text-success' : 'fa-check text-muted' }} me-2"></i>Verify your identity for trust</li>
                                        <li class="mb-0"><i class="fas {{ !empty($user->bio) ? 'fa-check text-success' : 'fa-check text-muted' }} me-2"></i>Write a compelling bio</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-user me-2"></i>Basic Info
                                </a>
                                <a href="{{ route('profile.tutor') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Tutor Profile
                                </a>
                                <a href="{{ route('profile.verification') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-id-card me-2"></i>ID Verification
                                </a>
                                <a href="{{ route('tutor.dashboard') }}" class="btn btn-success">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection