@extends('layouts.app')

@section('title', 'Student Profile - LearnWithExperts')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Profile Settings</h6>
                </div>
           {{-- In the sidebar --}}
<div class="list-group list-group-flush">
    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
        <i class="fas fa-user me-2"></i>Basic Information
    </a>
    <a href="{{ route('profile.student') }}" class="list-group-item list-group-item-action active"> {{-- CHANGE HERE --}}
        <i class="fas fa-user-graduate me-2"></i>Student Profile
    </a>
    <a href="{{ route('profile.verification') }}" class="list-group-item list-group-item-action">
        <i class="fas fa-id-card me-2"></i>ID Verification
    </a>
</div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Student Profile Information</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.student.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="education_level" class="form-label">Education Level *</label>
                                <select class="form-select @error('education_level') is-invalid @enderror" 
                                        id="education_level" name="education_level" required>
                                    <option value="">Select Level</option>
                                    <option value="primary" {{ old('education_level', $user->studentProfile->education_level ?? '') == 'primary' ? 'selected' : '' }}>Primary School</option>
                                    <option value="secondary" {{ old('education_level', $user->studentProfile->education_level ?? '') == 'secondary' ? 'selected' : '' }}>Secondary School</option>
                                    <option value="high_school" {{ old('education_level', $user->studentProfile->education_level ?? '') == 'high_school' ? 'selected' : '' }}>High School</option>
                                    <option value="undergraduate" {{ old('education_level', $user->studentProfile->education_level ?? '') == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                                    <option value="graduate" {{ old('education_level', $user->studentProfile->education_level ?? '') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                                </select>
                                @error('education_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="school_name" class="form-label">School/University</label>
                                <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" 
                                       value="{{ old('school_name', $user->studentProfile->school_name ?? '') }}">
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="learning_goals" class="form-label">Learning Goals</label>
                            <textarea class="form-control @error('learning_goals') is-invalid @enderror" 
                                      id="learning_goals" name="learning_goals" rows="3" 
                                      placeholder="What do you want to achieve?">{{ old('learning_goals', $user->studentProfile->learning_goals ?? '') }}</textarea>
                            @error('learning_goals')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preferred Subjects</label>
                            <div class="row">
                                @php
                                    $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science', 'Programming', 'Business Studies', 'Economics', 'History', 'Geography', 'Art', 'Music'];
                                    $preferredSubjects = $user->studentProfile->preferred_subjects ?? [];
                                    if (is_string($preferredSubjects)) {
                                        $preferredSubjects = json_decode($preferredSubjects, true) ?? [];
                                    }
                                @endphp
                                @foreach($subjects as $subject)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferred_subjects[]" 
                                                   value="{{ strtolower($subject) }}" 
                                                   id="subject_{{ $subject }}"
                                                   {{ in_array(strtolower($subject), $preferredSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_{{ $subject }}">{{ $subject }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('preferred_subjects')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">Parent/Guardian Information (Optional)</h6>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="parent_name" class="form-label">Parent/Guardian Name</label>
                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                       id="parent_name" name="parent_name" 
                                       value="{{ old('parent_name', $user->studentProfile->parent_name ?? '') }}">
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="parent_email" class="form-label">Parent/Guardian Email</label>
                                <input type="email" class="form-control @error('parent_email') is-invalid @enderror" 
                                       id="parent_email" name="parent_email" 
                                       value="{{ old('parent_email', $user->studentProfile->parent_email ?? '') }}">
                                @error('parent_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="parent_phone" class="form-label">Parent/Guardian Phone</label>
                                <input type="tel" class="form-control @error('parent_phone') is-invalid @enderror" 
                                       id="parent_phone" name="parent_phone" 
                                       value="{{ old('parent_phone', $user->studentProfile->parent_phone ?? '') }}">
                                @error('parent_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Student Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection