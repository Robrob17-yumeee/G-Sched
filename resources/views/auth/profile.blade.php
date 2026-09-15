@extends('layouts.app')

@section('title', ' - Profile')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Profile</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">

                    <!-- Profile Photo -->
                    <div class="text-center mb-4">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile Photo" class="profile-photo-preview" id="photoPreview">
                        @else
                            <div class="bg-light bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center profile-photo-placeholder" id="photoPlaceholder" style="width: 160px; height: 160px; background: rgba(66, 158, 189, 0.15) !important;">
                                <i class="bi bi-person fs-1"></i>
                            </div>
                        @endif
                        <div class="mt-3">
                            <label for="profile_photo" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-upload me-1"></i>Choose Photo
                            </label>
                            <input type="file" class="d-none" id="profile_photo" name="profile_photo" accept="image/*">
                        </div>
                        @error('profile_photo')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                        @if(auth()->user()->profile_photo)
                            <button type="button" class="btn btn-outline-danger btn-sm mt-2" id="removePhotoBtn">
                                <i class="bi bi-trash me-1"></i>Remove Photo
                            </button>
                        @endif
                    </div>

                    <!-- Display Name & Email (non-editable display) -->
                    <div class="text-center mb-4">
                        <h4>{{ auth()->user()->full_name }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <span class="badge bg-{{ auth()->user()->role->name === 'admin' ? 'danger' : (auth()->user()->role->name === 'guidance_associate' ? 'info' : 'success') }}">
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->role->name)) }}
                        </span>
                    </div>

                    <!-- Full Name -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Full Name</h6>
                        <p class="form-text text-muted">Your full name. This name is shown across G-SCHED instead of your email.</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ auth()->user()->first_name }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ auth()->user()->last_name }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ auth()->user()->middle_name }}">
                            @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if(auth()->user()->isStudent())
                    <!-- Student Demographics -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">School / Department</h6>
                        <div class="mb-3">
                            <select class="form-select @error('school') is-invalid @enderror" id="school" name="school">
                                <option value="">Select your school</option>
                                @foreach(\App\Models\User::getSchoolOptions() as $school)
                                    <option value="{{ $school }}" {{ auth()->user()->school == $school ? 'selected' : '' }}>{{ $school }}</option>
                                @endforeach
                            </select>
                            @error('school')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-3">Age</h6>
                            <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ auth()->user()->age }}" min="12" max="100">
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Age must be between 12 and 100</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-3">Gender</h6>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select your gender</option>
                                @foreach(\App\Models\User::getGenderOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ auth()->user()->gender == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif

                    @if(!auth()->user()->isStudent())
                    <!-- Assigned School (Guidance/Admin) -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Assigned School</h6>
                        <p class="form-text text-muted">All schools. School assignments are managed by the Guidance Counselor.</p>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="school" name="school" value="{{ auth()->user()->school }}">
                        </div>
                    </div>

                    <!-- Professional Title -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Professional Title</h6>
                        <p class="form-text text-muted">e.g. Registered Guidance Counselor</p>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="professional_title" name="professional_title" value="{{ auth()->user()->professional_title }}" placeholder="e.g. Registered Guidance Counselor">
                        </div>
                    </div>

                    <!-- Educational Background -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Educational Background</h6>
                        <p class="form-text text-muted">Degrees, universities and years</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="educational_background" name="educational_background" rows="3">{{ auth()->user()->educational_background }}</textarea>
                        </div>
                    </div>

                    <!-- Professional Credentials -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Professional Credentials</h6>
                        <p class="form-text text-muted">Licenses and professional credentials</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="professional_credentials" name="professional_credentials" rows="3">{{ auth()->user()->professional_credentials }}</textarea>
                        </div>
                    </div>

                    <!-- Certifications -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Certifications</h6>
                        <p class="form-text text-muted">Relevant certifications</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="certifications" name="certifications" rows="3">{{ auth()->user()->certifications }}</textarea>
                        </div>
                    </div>

                    <!-- Trainings -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Trainings</h6>
                        <p class="form-text text-muted">Specialized training programs attended</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="trainings" name="trainings" rows="3">{{ auth()->user()->trainings }}</textarea>
                        </div>
                    </div>

                    <!-- Areas of Expertise -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Areas of Expertise</h6>
                        <p class="form-text text-muted">Counseling specialties</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="areas_of_expertise" name="areas_of_expertise" rows="3">{{ auth()->user()->areas_of_expertise }}</textarea>
                        </div>
                    </div>

                    <!-- Professional Experience -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Professional Experience</h6>
                        <p class="form-text text-muted">Years of practice, roles and institutions</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="professional_experience" name="professional_experience" rows="3">{{ auth()->user()->professional_experience }}</textarea>
                        </div>
                    </div>

                    <!-- Professional Biography -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Professional Biography</h6>
                        <p class="form-text text-muted">A short professional summary</p>
                        <div class="mb-3">
                            <textarea class="form-control" id="professional_biography" name="professional_biography" rows="4">{{ auth()->user()->professional_biography }}</textarea>
                        </div>
                    </div>

                    <!-- Office / Location -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Office / Location</h6>
                        <p class="form-text text-muted">e.g. STCS Faculty Office</p>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="office_location" name="office_location" value="{{ auth()->user()->office_location }}" placeholder="e.g. STCS Faculty Office">
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->isStudent())
                    <!-- Student ID -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Student Information</h6>
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ auth()->user()->student_id }}" placeholder="xx-x-xxxxx (e.g., 23-1-12345)" pattern="^\d{2}-\d-\d{5}$">
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: YY-N-NNNNN (e.g., 23-1-12345)</div>
                        </div>
                    </div>
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');
    const removePhotoBtn = document.getElementById('removePhotoBtn');
    const removePhotoInput = document.getElementById('removePhotoInput');
    const previewContainer = photoPreview ? photoPreview.parentElement : (photoPlaceholder ? photoPlaceholder.parentElement : null);

    fileInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            removePhotoInput.value = '0';
            const reader = new FileReader();
            reader.onload = function(e) {
                let img = document.getElementById('photoPreview');
                if (!img) {
                    img = document.createElement('img');
                    img.id = 'photoPreview';
                    img.alt = 'Profile Photo';
                    img.className = 'profile-photo-preview';
                    if (photoPlaceholder) photoPlaceholder.remove();
                    previewContainer.appendChild(img);
                }
                img.src = e.target.result;
                if (removePhotoBtn) removePhotoBtn.style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }
    });

    removePhotoBtn?.addEventListener('click', function() {
        if (confirm('Are you sure you want to remove your profile photo?')) {
            removePhotoInput.value = '1';
            fileInput.value = '';
            const img = document.getElementById('photoPreview');
            if (img) img.remove();
            if (!document.getElementById('photoPlaceholder') && photoPlaceholder) {
                previewContainer.appendChild(photoPlaceholder);
            }
            removePhotoBtn.style.display = 'none';
        }
    });
});
</script>
@endsection
