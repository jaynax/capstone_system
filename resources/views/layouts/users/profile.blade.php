@extends('layouts.users.app')

@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="mb-4 text-center fw-bold">Edit Profile</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Image -->
            <div class="mb-4 text-center">
                <img id="profile-preview" 
                     src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/img/avatars/1.png') }}" 
                     class="rounded-circle border border-2 shadow-sm" 
                     width="150" 
                     height="150"
                     style="object-fit: cover;">
                <div class="mt-2">
                    <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                    <small class="text-muted">Upload a profile picture (JPEG, PNG, JPG, GIF - max 2MB)</small>
                </div>
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" id="name" name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email (read-only) -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" id="email" name="email" 
                       class="form-control" 
                       value="{{ Auth::user()->email }}" readonly>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label fw-semibold">Address</label>
                <input type="text" id="address" name="address" 
                       class="form-control @error('address') is-invalid @enderror" 
                       value="{{ old('address', Auth::user()->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                <input type="text" id="phone" name="phone" 
                       class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone', Auth::user()->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Update Profile</button>
            </div>
        </form>
    </div>
</div>

<!-- Image Preview Script -->
<script>
document.getElementById('profile_image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            this.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, JPG, GIF)');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function() {
            const newImage = reader.result;
            document.getElementById('profile-preview').src = newImage;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
