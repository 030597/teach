@extends('layouts.app')

@section('title', 'School Dashboard - LearnWithExperts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                    <h5>{{ auth()->user()->schoolProfile->school_name ?? auth()->user()->name }}</h5>
                    <p class="text-muted">School</p>
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
                        <a href="/school/teachers" class="btn btn-outline-primary btn-sm">Manage Teachers</a>
                        <a href="/school/students" class="btn btn-outline-success btn-sm">Student Management</a>
                        <a href="/school/classes" class="btn btn-outline-info btn-sm">Class Schedule</a>
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
                                    <h6>Total Teachers</h6>
                                    <h3>{{ auth()->user()->schoolProfile->total_teachers ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
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
                                    <h6>Total Students</h6>
                                    <h3>{{ auth()->user()->schoolProfile->total_students ?? 0 }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-graduate fa-2x"></i>
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
                                    <h6>Active Classes</h6>
                                    <h3>0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-book fa-2x"></i>
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
                                    <h6>Pending Requests</h6>
                                    <h3>0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- School Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">School Information</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->schoolProfile)
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>School Name:</strong> {{ auth()->user()->schoolProfile->school_name }}</p>
                                <p><strong>Address:</strong> {{ auth()->user()->schoolProfile->address }}</p>
                                <p><strong>City:</strong> {{ auth()->user()->schoolProfile->city }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Institution Type:</strong> {{ ucfirst(auth()->user()->schoolProfile->institution_type) }}</p>
                                <p><strong>Website:</strong> 
                                    @if(auth()->user()->schoolProfile->website)
                                        <a href="{{ auth()->user()->schoolProfile->website }}" target="_blank">{{ auth()->user()->schoolProfile->website }}</a>
                                    @else
                                        Not provided
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">No school profile information available.</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Complete School Profile</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Setup -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Setup Guide</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Complete School Profile</h6>
                                <small class="text-success"><i class="fas fa-check"></i> Done</small>
                            </div>
                            <p class="mb-1">Add detailed information about your school</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Add Teachers</h6>
                                <small class="text-warning">Pending</small>
                            </div>
                            <p class="mb-1">Register your teaching staff on the platform</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Set Up Classes</h6>
                                <small class="text-warning">Pending</small>
                            </div>
                            <p class="mb-1">Create class schedules and assign teachers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection