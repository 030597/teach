@extends('layouts.app')

@section('title', 'LearnWithExperts - Find Best Tutors Online')
@section('description', 'Connect with expert tutors for online and offline classes. Learn any subject at your own pace with qualified teachers.')
@section('keywords', 'tutoring, online classes, education, tutors, students, learning, teachers')

@section('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
}

.feature-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    border-radius: 15px;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.stat-number {
    font-size: 3rem;
    font-weight: bold;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.subject-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    margin: 5px;
    display: inline-block;
}
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <section class="hero-section text-white py-5">
        <div class="container">
            <div class="row align-items-center min-vh-80">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Learn with Expert Tutors</h1>
                    <p class="lead mb-4">Connect with qualified tutors for personalized learning experiences. Online and offline classes available for all subjects and levels.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register.student') }}" class="btn btn-light btn-lg px-4 py-3">
                            <i class="fas fa-user-graduate me-2"></i>Start Learning
                        </a>
                        <a href="{{ route('register.tutor') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Become a Tutor
                        </a>
                    </div>
                    <div class="mt-4">
                        <small class="text-white-50">
                            <i class="fas fa-shield-alt me-2"></i>All tutors are verified and background checked
                        </small>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2996/2996833.png" alt="Online Learning" class="img-fluid" style="max-height: 400px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </section>
<!-- Featured Tutors Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold display-5">Meet Our Expert Tutors</h2>
                <p class="lead text-muted">Learn from verified and experienced tutors</p>
                <a href="{{ route('tutors.index') }}" class="btn btn-outline-primary">View All Tutors</a>
            </div>
        </div>
        
        <div class="row">
            @foreach($featuredTutors as $tutor)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card tutor-card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <!-- Tutor Avatar -->
                        <img src="{{ $tutor->avatar_url }}" alt="{{ $tutor->name }}" 
                             class="rounded-circle mb-3" width="80" height="80" style="border: 3px solid #667eea;">
                        
                        <h5 class="fw-bold mb-1">{{ $tutor->name }}</h5>
                        
                        <!-- Verified Badge -->
                        <div class="mb-2">
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Verified
                            </span>
                        </div>

                        <p class="text-muted small mb-2">{{ $tutor->tutorProfile->headline ?? 'Expert Tutor' }}</p>

                        <!-- Subjects (first 2 only) -->
                        <div class="mb-3">
                            @if($tutor->tutorProfile && $tutor->tutorProfile->subjects)
                                @foreach(array_slice(json_decode($tutor->tutorProfile->subjects), 0, 2) as $subject)
                                    <span class="badge bg-light text-dark me-1 mb-1">{{ $subject }}</span>
                                @endforeach
                            @endif
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <span class="text-muted">4.5 (50+ reviews)</span>
                        </div>

                        <!-- Price and Action -->
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div>
                                <strong class="text-primary">
                                    ${{ number_format($tutor->tutorProfile->hourly_rate ?? 0, 2) }}/hr
                                </strong>
                            </div>
                            <a href="{{ route('tutors.show', $tutor->id) }}" class="btn btn-primary btn-sm">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($featuredTutors->isEmpty())
        <div class="row">
            <div class="col-12 text-center py-4">
                <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                <h5>No Tutors Available</h5>
                <p class="text-muted">Check back later for featured tutors</p>
            </div>
        </div>
        @endif
    </div>
</section>
    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number">500+</div>
                    <p class="text-muted">Expert Tutors</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number">10K+</div>
                    <p class="text-muted">Happy Students</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number">50+</div>
                    <p class="text-muted">Subjects</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number">24/7</div>
                    <p class="text-muted">Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold display-5">Why Choose LearnWithExperts?</h2>
                    <p class="lead text-muted">We provide the best tutoring experience with cutting-edge features</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-user-check fa-3x text-primary"></i>
                            </div>
                            <h5 class="fw-bold">Verified Tutors</h5>
                            <p class="text-muted">All tutors undergo thorough background checks, ID verification, and training to ensure quality education.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-laptop-code fa-3x text-primary"></i>
                            </div>
                            <h5 class="fw-bold">Interactive Online Classes</h5>
                            <p class="text-muted">Live video calls, interactive whiteboard, screen sharing, and real-time chat for engaging learning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-star fa-3x text-primary"></i>
                            </div>
                            <h5 class="fw-bold">Quality Guaranteed</h5>
                            <p class="text-muted">Money-back guarantee and free trial classes to ensure complete satisfaction with our services.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Subjects Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold display-5">Popular Subjects</h2>
                    <p class="lead">Learn any subject from expert tutors</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Mathematics</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Science</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">English</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Programming</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Physics</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Chemistry</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Biology</span>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <span class="subject-badge">Business Studies</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="fw-bold display-5 mb-4">Ready to Start Your Learning Journey?</h2>
            <p class="lead mb-4">Join thousands of students who are already learning with expert tutors</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register.student') }}" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-user-graduate me-2"></i>Join as Student
                </a>
                <a href="{{ route('register.tutor') }}" class="btn btn-outline-primary btn-lg px-5 py-3">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Become a Tutor
                </a>
                <a href="{{ route('register.school') }}" class="btn btn-outline-secondary btn-lg px-5 py-3">
                    <i class="fas fa-school me-2"></i>Register School
                </a>
            </div>
        </div>
    </section>
</div>
@endsection