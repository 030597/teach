@extends('layouts.app')

@section('title', 'Login - LearnWithExperts')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Login to Your Account</h2>
                </div>
                <div class="card-body p-5">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Login</button>

                        <div class="text-center">
                            <a href="/forgot-password" class="text-decoration-none">Forgot Your Password?</a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-3">Don't have an account?</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('register.student') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-graduate me-2"></i>Register as Student
                            </a>
                            <a href="{{ route('register.tutor') }}" class="btn btn-outline-success">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Register as Tutor
                            </a>
                            <a href="{{ route('register.school') }}" class="btn btn-outline-info">
                                <i class="fas fa-school me-2"></i>Register as School
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection