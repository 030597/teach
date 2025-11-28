@extends('layouts.app')

@section('title', 'Student Dashboard - LearnWithExperts')

@section('content')
{{-- Add this in the sidebar or main content --}}
@if(auth()->user()->studentProfile && (auth()->user()->studentProfile->parent_name || auth()->user()->studentProfile->parent_email))
<div class="card mt-3">
    <div class="card-header">
        <h6 class="mb-0">Parent Information</h6>
    </div>
    <div class="card-body">
        @if(auth()->user()->studentProfile->parent_name)
            <p class="mb-1"><strong>Name:</strong> {{ auth()->user()->studentProfile->parent_name }}</p>
        @endif
        @if(auth()->user()->studentProfile->parent_email)
            <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->studentProfile->parent_email }}</p>
        @endif
        @if(auth()->user()->studentProfile->parent_phone)
            <p class="mb-0"><strong>Phone:</strong> {{ auth()->user()->studentProfile->parent_phone }}</p>
        @endif
    </div>
</div>
@endif
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                    <h5>{{ auth()->user()->name }}</h5>
                    <p class="text-muted">Student</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/tutors" class="btn btn-outline-primary btn-sm">Find Tutors</a>
                        <a href="/my-bookings" class="btn btn-outline-success btn-sm">My Bookings</a>
                        <a href="/my-classes" class="btn btn-outline-info btn-sm">My Classes</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Total Classes</h5>
                                    <h2>0</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Completed</h5>
                                    <h2>0</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Upcoming</h5>
                                    <h2>0</h2>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No recent activity</h5>
                        <p class="text-muted">Start by booking your first class with a tutor</p>
                        <a href="/tutors" class="btn btn-primary">Find Tutors</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection