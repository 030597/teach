@extends('layouts.app')

@section('title', 'Tutor Profile - LearnWithExperts')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Profile Settings</h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user me-2"></i>Basic Information
                    </a>
                    <a href="{{ route('profile.tutor') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Tutor Profile
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
                    <h5 class="mb-0">Tutor Profile Information</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
{{-- Add this after the success message --}}
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    To update your email, password, name, or profile picture, please visit the 
    <a href="{{ route('profile.edit') }}" class="alert-link">Basic Information</a> page.
</div>
                    <form method="POST" action="{{ route('profile.tutor.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="headline" class="form-label">Professional Headline *</label>
                            <input type="text" class="form-control @error('headline') is-invalid @enderror" 
                                   id="headline" name="headline" 
                                   value="{{ old('headline', $user->tutorProfile->headline ?? '') }}" 
                                   placeholder="e.g., Mathematics Expert with 5+ years experience" required>
                            @error('headline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subjects You Can Teach *</label>
                            <div class="row">
                                @php
                                    $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science', 'Programming', 'Business Studies', 'Economics', 'History', 'Geography', 'Art', 'Music'];
                                    $tutorSubjects = $user->tutorProfile->subjects ?? [];
                                    if (is_string($tutorSubjects)) {
                                        $tutorSubjects = json_decode($tutorSubjects, true) ?? [];
                                    }
                                @endphp
                                @foreach($subjects as $subject)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subjects[]" 
                                                   value="{{ strtolower($subject) }}" 
                                                   id="tutor_subject_{{ $subject }}"
                                                   {{ in_array(strtolower($subject), $tutorSubjects) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tutor_subject_{{ $subject }}">{{ $subject }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('subjects')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hourly_rate" class="form-label">Hourly Rate ($) *</label>
                                <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                       id="hourly_rate" name="hourly_rate" 
                                       value="{{ old('hourly_rate', $user->tutorProfile->hourly_rate ?? '') }}" 
                                       min="0" step="0.01" required>
                                @error('hourly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="experience_years" class="form-label">Years of Experience *</label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                       id="experience_years" name="experience_years" 
                                       value="{{ old('experience_years', $user->tutorProfile->experience_years ?? '') }}" 
                                       min="0" required>
                                @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="teaching_mode" class="form-label">Teaching Mode *</label>
                            <select class="form-select @error('teaching_mode') is-invalid @enderror" 
                                    id="teaching_mode" name="teaching_mode" required>
                                <option value="">Select Mode</option>
                                <option value="online" {{ old('teaching_mode', $user->tutorProfile->teaching_mode ?? '') == 'online' ? 'selected' : '' }}>Online Only</option>
                                <option value="offline" {{ old('teaching_mode', $user->tutorProfile->teaching_mode ?? '') == 'offline' ? 'selected' : '' }}>Offline Only</option>
                                <option value="both" {{ old('teaching_mode', $user->tutorProfile->teaching_mode ?? '') == 'both' ? 'selected' : '' }}>Both Online & Offline</option>
                            </select>
                            @error('teaching_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" 
                                   value="{{ old('location', $user->tutorProfile->location ?? '') }}"
                                   placeholder="City, Country">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Education Section -->
                        <div class="mb-4">
                            <h6>Education Background</h6>
                            <div id="education-fields">
                                @php
                                    $education = $user->tutorProfile->education ?? [];
                                    if (is_string($education)) {
                                        $education = json_decode($education, true) ?? [];
                                    }
                                @endphp
                                
                                @if(!empty($education))
                                    @foreach($education as $index => $edu)
                                        <div class="row mb-2 education-field">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="education[{{ $index }}][degree]" 
                                                       value="{{ $edu['degree'] ?? '' }}" placeholder="Degree">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="education[{{ $index }}][institution]" 
                                                       value="{{ $edu['institution'] ?? '' }}" placeholder="Institution">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="education[{{ $index }}][year]" 
                                                       value="{{ $edu['year'] ?? '' }}" placeholder="Year">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-education">×</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 education-field">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="education[0][degree]" placeholder="Degree">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="education[0][institution]" placeholder="Institution">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="education[0][year]" placeholder="Year">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-education">×</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-education">
                                <i class="fas fa-plus me-1"></i>Add Education
                            </button>
                        </div>

                        <!-- Experience Section -->
                        <div class="mb-4">
                            <h6>Teaching Experience</h6>
                            <div id="experience-fields">
                                @php
                                    $experience = $user->tutorProfile->experience ?? [];
                                    if (is_string($experience)) {
                                        $experience = json_decode($experience, true) ?? [];
                                    }
                                @endphp
                                
                                @if(!empty($experience))
                                    @foreach($experience as $index => $exp)
                                        <div class="row mb-2 experience-field">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="experience[{{ $index }}][position]" 
                                                       value="{{ $exp['position'] ?? '' }}" placeholder="Position">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="experience[{{ $index }}][organization]" 
                                                       value="{{ $exp['organization'] ?? '' }}" placeholder="Organization">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" name="experience[{{ $index }}][duration]" 
                                                       value="{{ $exp['duration'] ?? '' }}" placeholder="Duration">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="experience[{{ $index }}][description]" 
                                                       value="{{ $exp['description'] ?? '' }}" placeholder="Description">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-experience">×</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-2 experience-field">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="experience[0][position]" placeholder="Position">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="experience[0][organization]" placeholder="Organization">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="experience[0][duration]" placeholder="Duration">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="experience[0][description]" placeholder="Description">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-experience">×</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-experience">
                                <i class="fas fa-plus me-1"></i>Add Experience
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Tutor Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Education Fields
    let educationIndex = {{ !empty($education) ? count($education) : 1 }};
    document.getElementById('add-education').addEventListener('click', function() {
        const field = document.createElement('div');
        field.className = 'row mb-2 education-field';
        field.innerHTML = `
            <div class="col-md-4">
                <input type="text" class="form-control" name="education[${educationIndex}][degree]" placeholder="Degree">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="education[${educationIndex}][institution]" placeholder="Institution">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="education[${educationIndex}][year]" placeholder="Year">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-education">×</button>
            </div>
        `;
        document.getElementById('education-fields').appendChild(field);
        educationIndex++;
    });

    // Experience Fields
    let experienceIndex = {{ !empty($experience) ? count($experience) : 1 }};
    document.getElementById('add-experience').addEventListener('click', function() {
        const field = document.createElement('div');
        field.className = 'row mb-2 experience-field';
        field.innerHTML = `
            <div class="col-md-3">
                <input type="text" class="form-control" name="experience[${experienceIndex}][position]" placeholder="Position">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="experience[${experienceIndex}][organization]" placeholder="Organization">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="experience[${experienceIndex}][duration]" placeholder="Duration">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="experience[${experienceIndex}][description]" placeholder="Description">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-experience">×</button>
            </div>
        `;
        document.getElementById('experience-fields').appendChild(field);
        experienceIndex++;
    });

    // Remove education field
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education')) {
            e.target.closest('.education-field').remove();
        }
        if (e.target.classList.contains('remove-experience')) {
            e.target.closest('.experience-field').remove();
        }
    });
});
</script>
@endsection
@endsection