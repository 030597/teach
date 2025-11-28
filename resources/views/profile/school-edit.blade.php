@extends('layouts.app')

@section('title', 'School Profile - LearnWithExperts')

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
                    <a href="{{ route('profile.school') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-school me-2"></i>School Profile
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
                    <h5 class="mb-0">School Profile Information</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.school.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="school_name" class="form-label">School Name *</label>
                                <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" 
                                       value="{{ old('school_name', $user->schoolProfile->school_name ?? '') }}" required>
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="institution_type" class="form-label">Institution Type *</label>
                                <select class="form-select @error('institution_type') is-invalid @enderror" 
                                        id="institution_type" name="institution_type" required>
                                    <option value="">Select Type</option>
                                    <option value="school" {{ old('institution_type', $user->schoolProfile->institution_type ?? '') == 'school' ? 'selected' : '' }}>School</option>
                                    <option value="college" {{ old('institution_type', $user->schoolProfile->institution_type ?? '') == 'college' ? 'selected' : '' }}>College</option>
                                    <option value="university" {{ old('institution_type', $user->schoolProfile->institution_type ?? '') == 'university' ? 'selected' : '' }}>University</option>
                                    <option value="coaching_center" {{ old('institution_type', $user->schoolProfile->institution_type ?? '') == 'coaching_center' ? 'selected' : '' }}>Coaching Center</option>
                                </select>
                                @error('institution_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="registration_number" class="form-label">Registration Number</label>
                            <input type="text" class="form-control @error('registration_number') is-invalid @enderror" 
                                   id="registration_number" name="registration_number" 
                                   value="{{ old('registration_number', $user->schoolProfile->registration_number ?? '') }}">
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" 
                                   value="{{ old('address', $user->schoolProfile->address ?? '') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" 
                                       value="{{ old('city', $user->schoolProfile->city ?? '') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" 
                                       value="{{ old('country', $user->schoolProfile->country ?? '') }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                       id="website" name="website" 
                                       value="{{ old('website', $user->schoolProfile->website ?? '') }}"
                                       placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="total_students" class="form-label">Total Students</label>
                                <input type="number" class="form-control @error('total_students') is-invalid @enderror" 
                                       id="total_students" name="total_students" 
                                       value="{{ old('total_students', $user->schoolProfile->total_students ?? '') }}" 
                                       min="0">
                                @error('total_students')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="total_teachers" class="form-label">Total Teachers</label>
                                <input type="number" class="form-control @error('total_teachers') is-invalid @enderror" 
                                       id="total_teachers" name="total_teachers" 
                                       value="{{ old('total_teachers', $user->schoolProfile->total_teachers ?? '') }}" 
                                       min="0">
                                @error('total_teachers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Grades Offered</label>
                            <div class="row">
                                @php
                                    $grades = ['Primary', 'Secondary', 'High School', 'Undergraduate', 'Graduate'];
                                    $offeredGrades = $user->schoolProfile->grades_offered ?? [];
                                    if (is_string($offeredGrades)) {
                                        $offeredGrades = json_decode($offeredGrades, true) ?? [];
                                    }
                                @endphp
                                @foreach($grades as $grade)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="grades_offered[]" 
                                                   value="{{ strtolower($grade) }}" 
                                                   id="grade_{{ $grade }}"
                                                   {{ in_array(strtolower($grade), $offeredGrades) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="grade_{{ $grade }}">{{ $grade }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="facilities" class="form-label">Facilities</label>
                            <textarea class="form-control @error('facilities') is-invalid @enderror" 
                                      id="facilities" name="facilities" rows="3" 
                                      placeholder="Describe your school facilities...">{{ old('facilities', $user->schoolProfile->facilities ?? '') }}</textarea>
                            @error('facilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update School Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection