@extends('layouts.app')

@section('title', 'Student Registration - LearnWithExperts')
@section('description', 'Join as a student to find the best tutors for your learning needs.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Student Registration</h2>
                    <p class="mb-0 mt-2">Start your learning journey with expert tutors</p>
                </div>
                <div class="card-body p-5">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.student') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="education_level" class="form-label">Education Level *</label>
                                <select class="form-select @error('education_level') is-invalid @enderror" 
                                        id="education_level" name="education_level" required>
                                    <option value="">Select Level</option>
                                    <option value="primary" {{ old('education_level') == 'primary' ? 'selected' : '' }}>Primary School</option>
                                    <option value="secondary" {{ old('education_level') == 'secondary' ? 'selected' : '' }}>Secondary School</option>
                                    <option value="high_school" {{ old('education_level') == 'high_school' ? 'selected' : '' }}>High School</option>
                                    <option value="undergraduate" {{ old('education_level') == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                                    <option value="graduate" {{ old('education_level') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                                </select>
                                @error('education_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="school_name" class="form-label">School/University</label>
                                <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" value="{{ old('school_name') }}">
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="learning_goals" class="form-label">Learning Goals</label>
                            <textarea class="form-control @error('learning_goals') is-invalid @enderror" 
                                      id="learning_goals" name="learning_goals" rows="3" 
                                      placeholder="What do you want to achieve?">{{ old('learning_goals') }}</textarea>
                            @error('learning_goals')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preferred Subjects</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="preferred_subjects[]" value="mathematics" id="math">
                                        <label class="form-check-label" for="math">Mathematics</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="preferred_subjects[]" value="science" id="science">
                                        <label class="form-check-label" for="science">Science</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="preferred_subjects[]" value="english" id="english">
                                        <label class="form-check-label" for="english">English</label>
                                    </div>
                                </div>
                            </div>
                        </div>
{{-- Add this before the terms checkbox --}}
<hr class="my-4">

<h6 class="mb-3">Parent/Guardian Information (Optional)</h6>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="parent_name" class="form-label">Parent/Guardian Name</label>
        <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
               id="parent_name" name="parent_name" value="{{ old('parent_name') }}">
        @error('parent_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label for="parent_email" class="form-label">Parent/Guardian Email</label>
        <input type="email" class="form-control @error('parent_email') is-invalid @enderror" 
               id="parent_email" name="parent_email" value="{{ old('parent_email') }}">
        @error('parent_email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="parent_phone" class="form-label">Parent/Guardian Phone</label>
        <input type="tel" class="form-control @error('parent_phone') is-invalid @enderror" 
               id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}">
        @error('parent_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="/terms" target="_blank">Terms and Conditions</a> and <a href="/privacy" target="_blank">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Create Student Account</button>
                    </form>

                    <div class="text-center mt-4">
                        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection