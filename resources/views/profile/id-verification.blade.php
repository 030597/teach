@extends('layouts.app')

@section('title', 'ID Verification - LearnWithExperts')

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
                    @if(auth()->user()->isStudent())
                        <a href="{{ route('profile.student') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-graduate me-2"></i>Student Profile
                        </a>
                    @endif
                    @if(auth()->user()->isTutor())
                        <a href="{{ route('profile.tutor') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Tutor Profile
                        </a>
                    @endif
                    @if(auth()->user()->isSchool())
                        <a href="{{ route('profile.school') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-school me-2"></i>School Profile
                        </a>
                    @endif
                    <a href="{{ route('profile.verification') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-id-card me-2"></i>ID Verification
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ID Verification</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Verification Status -->
                    @if($verification)
                        <div class="alert 
                            @if($verification->status == 'verified') alert-success
                            @elseif($verification->status == 'rejected') alert-danger
                            @else alert-warning @endif">
                            <h6>
                                @if($verification->status == 'verified')
                                    <i class="fas fa-check-circle me-2"></i>ID Verified
                                @elseif($verification->status == 'rejected')
                                    <i class="fas fa-times-circle me-2"></i>Verification Rejected
                                @else
                                    <i class="fas fa-clock me-2"></i>Verification Under Review
                                @endif
                            </h6>
                            @if($verification->status == 'rejected' && $verification->admin_notes)
                                <p class="mb-0 mt-2"><strong>Reason:</strong> {{ $verification->admin_notes }}</p>
                            @endif
                            @if($verification->verified_at)
                                <p class="mb-0 mt-2"><strong>Verified on:</strong> {{ $verification->verified_at->format('M d, Y') }}</p>
                            @endif
                        </div>
                    @endif

                    @if(!$verification || $verification->status == 'rejected')
                    <form method="POST" action="{{ route('profile.verification.submit') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <h6>Document Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="document_type" class="form-label">Document Type *</label>
                                    <select class="form-select @error('document_type') is-invalid @enderror" 
                                            id="document_type" name="document_type" required>
                                        <option value="">Select Document Type</option>
                                        <option value="cnic" {{ old('document_type') == 'cnic' ? 'selected' : '' }}>CNIC</option>
                                        <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="license" {{ old('document_type') == 'license' ? 'selected' : '' }}>Driver's License</option>
                                    </select>
                                    @error('document_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="document_number" class="form-label">Document Number *</label>
                                    <input type="text" class="form-control @error('document_number') is-invalid @enderror" 
                                           id="document_number" name="document_number" 
                                           value="{{ old('document_number') }}" required>
                                    @error('document_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6>Document Images</h6>
                            <p class="text-muted">Upload clear images of your documents. Make sure all details are readable.</p>
                            
                            <!-- Front Image -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="front_image" class="form-label">Front Side *</label>
                                    <input type="file" class="form-control @error('front_image') is-invalid @enderror" 
                                           id="front_image" name="front_image" accept="image/*" required>
                                    @error('front_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Front side of your document</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 text-center bg-light">
                                        <i class="fas fa-id-card fa-2x text-muted mb-2"></i>
                                        <p class="small text-muted mb-0">Front side preview</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Back Image -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="back_image" class="form-label">Back Side</label>
                                    <input type="file" class="form-control @error('back_image') is-invalid @enderror" 
                                           id="back_image" name="back_image" accept="image/*">
                                    @error('back_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                    <small class="text-muted">Back side of your document (if applicable)</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 text-center bg-light">
                                        <i class="fas fa-id-card fa-2x text-muted mb-2"></i>
                                        <p class="small text-muted mb-0">Back side preview</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Selfie Image -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="selfie_image" class="form-label">Selfie with Document *</label>
                                    <input type="file" class="form-control @error('selfie_image') is-invalid @enderror" 
                                           id="selfie_image" name="selfie_image" accept="image/*" required>
                                    @error('selfie_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Take a selfie holding your document</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 text-center bg-light">
                                        <i class="fas fa-camera fa-2x text-muted mb-2"></i>
                                        <p class="small text-muted mb-0">Selfie preview</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Important Guidelines</h6>
                            <ul class="mb-0 small">
                                <li>Ensure all images are clear and readable</li>
                                <li>File size should not exceed 5MB per image</li>
                                <li>Supported formats: JPG, PNG, JPEG</li>
                                <li>Make sure your face is visible in the selfie</li>
                                <li>Document details should be clearly visible</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit for Verification</button>
                    </form>
                    @elseif($verification->status == 'pending')
                        <div class="text-center py-4">
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h5 class="text-warning">Verification Under Review</h5>
                            <p class="text-muted">Your ID verification is currently being reviewed by our team.</p>
                            <p class="text-muted">This process usually takes 24-48 hours.</p>
                        </div>
                    @elseif($verification->status == 'verified')
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">ID Verified Successfully</h5>
                            <p class="text-muted">Your identity has been verified.</p>
                            <p class="text-muted">Verified on: {{ $verification->verified_at->format('F d, Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Image preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const frontImageInput = document.getElementById('front_image');
    const backImageInput = document.getElementById('back_image');
    const selfieImageInput = document.getElementById('selfie_image');

    function setupImagePreview(input, previewIndex) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = input.closest('.row').querySelector('.col-md-6:last-child');
                    previewContainer.innerHTML = `
                        <div class="border rounded p-2">
                            <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                            <p class="small text-muted mt-2 mb-0">Preview</p>
                        </div>
                    `;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    if (frontImageInput) setupImagePreview(frontImageInput, 1);
    if (backImageInput) setupImagePreview(backImageInput, 2);
    if (selfieImageInput) setupImagePreview(selfieImageInput, 3);
});
</script>
@endsection
@endsection