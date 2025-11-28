@extends('layouts.app')

@section('title', 'Tutor Registration - LearnWithExperts')
@section('description', 'Become a tutor and share your knowledge with students worldwide.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Tutor Registration</h2>
                    <p class="mb-0 mt-2">Share your expertise and earn while teaching</p>
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

                    <form method="POST" action="{{ route('register.tutor') }}">
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

                        <div class="mb-3">
                            <label for="headline" class="form-label">Professional Headline *</label>
                            <input type="text" class="form-control @error('headline') is-invalid @enderror" 
                                   id="headline" name="headline" value="{{ old('headline') }}" 
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
                                @endphp
                                @foreach($subjects as $subject)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="subjects[]" 
                                                   value="{{ strtolower($subject) }}" id="{{ $subject }}">
                                            <label class="form-check-label" for="{{ $subject }}">{{ $subject }}</label>
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
                                       id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" 
                                       min="0" step="0.01" required>
                                @error('hourly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="experience_years" class="form-label">Years of Experience *</label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                       id="experience_years" name="experience_years" value="{{ old('experience_years') }}" 
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
                                <option value="online" {{ old('teaching_mode') == 'online' ? 'selected' : '' }}>Online Only</option>
                                <option value="offline" {{ old('teaching_mode') == 'offline' ? 'selected' : '' }}>Offline Only</option>
                                <option value="both" {{ old('teaching_mode') == 'both' ? 'selected' : '' }}>Both Online & Offline</option>
                            </select>
                            @error('teaching_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="/terms" target="_blank">Terms and Conditions</a> and <a href="/privacy" target="_blank">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Become a Tutor</button>
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