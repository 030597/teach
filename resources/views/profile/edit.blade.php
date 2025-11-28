@extends('layouts.app')

@section('title', 'Edit Profile - LearnWithExperts')

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
    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action active">
        <i class="fas fa-user me-2"></i>Basic Information
    </a>
    @if(auth()->user()->isStudent())
        <a href="{{ route('profile.student') }}" class="list-group-item list-group-item-action"> {{-- CHANGE HERE --}}
            <i class="fas fa-user-graduate me-2"></i>Student Profile
        </a>
    @endif
    @if(auth()->user()->isTutor())
        <a href="{{ route('profile.tutor') }}" class="list-group-item list-group-item-action"> {{-- CHANGE HERE --}}
            <i class="fas fa-chalkboard-teacher me-2"></i>Tutor Profile
        </a>
    @endif
    @if(auth()->user()->isSchool())
        <a href="{{ route('profile.school') }}" class="list-group-item list-group-item-action"> {{-- CHANGE HERE --}}
            <i class="fas fa-school me-2"></i>School Profile
        </a>
    @endif
    <a href="{{ route('profile.verification') }}" class="list-group-item list-group-item-action">
        <i class="fas fa-id-card me-2"></i>ID Verification
    </a>
</div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

               <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="mb-3">
                <img src="{{ auth()->user()->avatar ? asset('images/avatars/' . auth()->user()->avatar) : asset('images/avatars/avatar.png') }}" 
                     alt="Avatar" class="rounded-circle" width="150" height="150" id="avatarPreview">
            </div>
            <div class="mb-3">
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                       id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)">
                @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <small class="text-muted">Max file size: 6MB. Supported formats: JPG, PNG, GIF, WebP</small>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number *</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="timezone" class="form-label">Timezone *</label>
                <select class="form-select @error('timezone') is-invalid @enderror" 
                        id="timezone" name="timezone" required>
                    <option value="UTC" {{ auth()->user()->timezone == 'UTC' ? 'selected' : '' }}>UTC</option>
                    <option value="America/New_York" {{ auth()->user()->timezone == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                    <option value="America/Chicago" {{ auth()->user()->timezone == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                    <option value="America/Denver" {{ auth()->user()->timezone == 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                    <option value="America/Los_Angeles" {{ auth()->user()->timezone == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                    <option value="Europe/London" {{ auth()->user()->timezone == 'Europe/London' ? 'selected' : '' }}>London</option>
                    <option value="Europe/Paris" {{ auth()->user()->timezone == 'Europe/Paris' ? 'selected' : '' }}>Paris</option>
                    <option value="Asia/Karachi" {{ auth()->user()->timezone == 'Asia/Karachi' ? 'selected' : '' }}>Karachi</option>
                    <option value="Asia/Dubai" {{ auth()->user()->timezone == 'Asia/Dubai' ? 'selected' : '' }}>Dubai</option>
                </select>
                @error('timezone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control @error('bio') is-invalid @enderror" 
                          id="bio" name="bio" rows="4" 
                          placeholder="Tell us about yourself...">{{ old('bio', auth()->user()->bio) }}</textarea>
                @error('bio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

           <div class="row">

    <!-- Current Password Leave password blank if you don't want to change -->
    <div class="col-md-6 mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <div class="input-group">
            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                   id="current_password" name="current_password">
            <span class="input-group-text" onclick="togglePassword('current_password', this)">
                <i class="fa fa-eye"></i>
            </span>
        </div>
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- New Password -->
    <div class="col-md-6 mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <div class="input-group">
            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                   id="new_password" name="new_password">
            <span class="input-group-text" onclick="togglePassword('new_password', this)">
                <i class="fa fa-eye"></i>
            </span>
        </div>
        @error('new_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm New Password -->
    <div class="col-md-6 mb-3">
        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
        <div class="input-group">
            <input type="password" class="form-control"
                   id="new_password_confirmation" name="new_password_confirmation">
            <span class="input-group-text" onclick="togglePassword('new_password_confirmation', this)">
                <i class="fa fa-eye"></i>
            </span>
        </div>
    </div>

</div>

            <!-- END PASSWORD FIELDS -->

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


@endsection
<script >
function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);

    if (input.type === "password") {
        input.type = "text";
        el.querySelector("i").classList.remove("fa-eye");
        el.querySelector("i").classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        el.querySelector("i").classList.remove("fa-eye-slash");
        el.querySelector("i").classList.add("fa-eye");
    }
}
</script>

</script>

@endsection