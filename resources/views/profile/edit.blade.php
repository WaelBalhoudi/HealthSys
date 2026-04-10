@extends('layouts.app')

@section('title', 'Mon profil')
@section('page-title', 'Modifier mon profil')

@section('content')
<div class="row">
    <div class="col-md-8 w-100">

        <!-- ✅ ONE FORM WRAPS EVERYTHING -->
        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ================= AVATAR CARD ================= -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Photo de profil</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start gap-4">

                        @php
                            if (auth()->user()->avatar && file_exists(storage_path('app/public/' . auth()->user()->avatar))) {
                                $avatarSrc = asset('storage/' . auth()->user()->avatar);
                            } else {
                                $avatarSrc = asset('assets/img/avatars/user.png');
                            }
                        @endphp
                        
                        <!-- Avatar -->
                        <div class="position-relative">
                            <img 
                                src="{{ $avatarSrc }}" 
                                alt="user-avatar"
                                class="d-block rounded-circle border shadow-sm"
                                height="100"
                                width="100"
                                id="avatarPreview"
                                style="object-fit: cover;"
                            />
                            <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1 border border-white" 
                                  style="width: 20px; height: 20px; font-size: 10px; display: flex; align-items: center; justify-content-center;">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                        
                        <!-- Upload Controls -->
                        <div class="button-wrapper">
                            <label for="avatarUpload" class="btn btn-primary me-2 mb-2">
                                <i class="fas fa-upload me-1"></i>
                                <span class="d-none d-sm-inline">Télécharger une photo</span>
                                <input type="file" id="avatarUpload" name="avatar" class="d-none" accept="image/png, image/jpeg, image/jpg">
                            </label>

                            <button type="button" class="btn btn-outline-secondary mb-2" id="resetAvatar">
                                <i class="fas fa-undo me-1"></i>
                                <span class="d-none d-sm-inline">Réinitialiser</span>
                            </button>

                            <p class="text-muted small mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                JPG, PNG ou GIF. Max 2MB.
                            </p>

                            @error('avatar')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= INFO CARD ================= -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Informations personnelles</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', auth()->user()->phone) }}" placeholder="+216 XX XXX XXX">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de naissance</label>
                            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   value="{{ old('birth_date', auth()->user()->birth_date) }}" max="{{ date('Y-m-d') }}">
                            @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                      rows="2">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- PASSWORD -->
                    <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Changer le mot de passe</h6>
                    <p class="text-muted small mb-3">Laissez vide si vous ne souhaitez pas le modifier.</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-custom px-4">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                            Annuler
                        </a>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>
@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatarUpload');
    const avatarPreview = document.getElementById('avatarPreview');
    const resetBtn = document.getElementById('resetAvatar');
    const form = document.getElementById('profileForm');

    const originalAvatar = avatarPreview.src;

    form.addEventListener('submit', function() {
        console.log('Submitting...');
        console.log('enctype:', form.enctype);
        console.log('file:', avatarInput.files[0]);
    });

    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Format non supporté');
            avatarInput.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Fichier trop lourd');
            avatarInput.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => avatarPreview.src = e.target.result;
        reader.readAsDataURL(file);
    });

    resetBtn.addEventListener('click', function() {
        avatarPreview.src = originalAvatar;
        avatarInput.value = '';
    });
});
</script>
@endpush



@push('styles')
<style>
#avatarPreview {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
#avatarPreview:hover {
    transform: scale(1.03);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    cursor: pointer;
}

.btn-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}
.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>
@endpush