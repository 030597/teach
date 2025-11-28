@extends('layouts.app')

@section('title', 'My Students - Tutor')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">My Students</h4>
                </div>
                <div class="card-body">
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Education Level</th>
                                        <th>Preferred Subjects</th>
                                        <th>Total Sessions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $student->avatar_url }}" alt="Avatar" class="rounded-circle me-3" width="40" height="40">
                                                <div>
                                                    <strong>{{ $student->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $student->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $student->studentProfile->education_level ?? 'N/A' }}</td>
                                        <td>
                                            @if($student->studentProfile && $student->studentProfile->preferred_subjects)
                                                @foreach(json_decode($student->studentProfile->preferred_subjects) as $subject)
                                                    <span class="badge bg-secondary me-1">{{ $subject }}</span>
                                                @endforeach
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $student->bookings->count() }} sessions
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('tutor.students.show', $student->id) }}" class="btn btn-sm btn-outline-primary">
                                                View Profile
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>No Students Yet</h5>
                            <p class="text-muted">You don't have any students yet. Your students will appear here once they book sessions with you.</p>
                            <a href="{{ route('tutor.schedule') }}" class="btn btn-primary">
                                Set Your Availability
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection