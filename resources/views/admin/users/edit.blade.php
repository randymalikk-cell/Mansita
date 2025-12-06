@extends('layouts.app')

@section('content')
<style>
    .breadcrumb-link {
        color: #6c6c6c;
        text-decoration: none;
        position: relative;
        font-weight: 600;
        padding-bottom: 2px;
    }

    .breadcrumb-link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0%;
        height: 2px;
        background: #2563eb;
        transition: width 0.25s ease-in-out;
    }

    .breadcrumb-link:hover::after {
        width: 100%;
    }

    .breadcrumb-link:hover {
        color: #2563eb;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 32px;
    }
    
    .form-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 24px;
        border-bottom: 2px solid #F1F5F9;
        margin-bottom: 32px;
    }
    
    .form-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }
    
    .form-header-content h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }
    
    .form-header-content p {
        font-size: 14px;
        color: #64748B;
        margin: 4px 0 0 0;
    }
    
    .user-info-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #F1F5F9;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-left: auto;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        font-weight: 600;
        color: #334155;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-label .required {
        color: #EF4444;
        margin-left: 4px;
    }
    
    .form-control, .form-select {
        border: 2px solid #E2E8F0;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.2s;
        width: 100%;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #EF4444;
    }
    
    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }
    
    .invalid-feedback {
        display: block;
        color: #EF4444;
        font-size: 13px;
        margin-top: 6px;
        font-weight: 500;
    }
    
    .form-text {
        font-size: 13px;
        color: #64748B;
        margin-top: 6px;
        display: block;
    }
    
    .info-box {
        background: #EFF6FF;
        border-left: 4px solid #3B82F6;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    
    .info-box i {
        color: #3B82F6;
        font-size: 18px;
        margin-right: 8px;
    }
    
    .info-box p {
        margin: 0;
        color: #1E40AF;
        font-size: 14px;
    }
    
    .btn-primary {
        background: #3B82F6;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background: #2563EB;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-secondary {
        background: #F1F5F9;
        color: #64748B;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
    }
    
    .btn-secondary:hover {
        background: #E2E8F0;
        color: #475569;
    }
    
    .btn-danger {
        background: #FEF2F2;
        color: #DC2626;
        border: 2px solid #FEE2E2;
        padding: 10px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
    }
    
    .btn-danger:hover {
        background: #DC2626;
        color: white;
        border-color: #DC2626;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 24px;
        border-top: 2px solid #F1F5F9;
        margin-top: 32px;
        justify-content: space-between;
        align-items: center;
    }
    
    .form-actions-left {
        display: flex;
        gap: 12px;
    }
    
    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #64748B;
        z-index: 10;
    }
    
    .password-wrapper {
        position: relative;
    }
</style>

<header class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Edit Pengguna</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<h2>
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('admin.users.index') }}" class="breadcrumb-link">Manajemen Pengguna</a>
    > <span style="color:#27d436ff; font-weight:700;">Edit Pengguna</span>
</h2>

<div class="container-fluid px-0">
    
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="form-header-content">
                <h2>Form Edit Data Pengguna</h2>
                <p>Perbarui informasi pengguna: <strong>{{ $user->nama }}</strong></p>
            </div>
            <div class="user-info-badge">
                <i class="bi bi-person-circle"></i>
                {{ $user->username }}
            </div>
        </div>

        <div class="info-box">
            <i class="bi bi-info-circle-fill"></i>
            <span style="color: #1E40AF; font-weight: 600;">Tips:</span>
            <span style="color: #1E40AF;"> Kosongkan field password jika tidak ingin mengubah password pengguna.</span>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="nama">
                            Nama Lengkap<span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $user->nama) }}" 
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="username">
                            Username<span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username', $user->username) }}" 
                               placeholder="Masukkan username"
                               required>
                        <small class="form-text">Username untuk login sistem</small>
                        @error('username')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="email">
                            Email
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               placeholder="contoh@email.com">
                        <small class="form-text">Opsional - untuk fitur 2FA dan notifikasi</small>
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="role">
                            Role / Peran<span class="required">*</span>
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" 
                                name="role" 
                                required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                👑 Admin
                            </option>
                            <option value="pengurus" {{ old('role', $user->role) == 'pengurus' ? 'selected' : '' }}>
                                👤 Pengurus
                            </option>
                            <option value="staf produksi" {{ old('role', $user->role) == 'staf produksi' ? 'selected' : '' }}>
                                🏭 Staf Produksi
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="password">
                            Password Baru
                        </label>
                        <div class="password-wrapper">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Kosongkan jika tidak diubah">
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('password')"></i>
                        </div>
                        <small class="form-text">Minimal 8 karakter jika ingin mengubah password</small>
                        @error('password')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">
                            Konfirmasi Password Baru
                        </label>
                        <div class="password-wrapper">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password baru">
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('password_confirmation')"></i>
                        </div>
                        <small class="form-text">Ketik ulang password yang sama</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="form-actions-left">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
                
                <button type="button" 
                        class="btn btn-danger" 
                        onclick="if(confirm('Yakin ingin menghapus pengguna ini?')) document.getElementById('delete-form').submit()">
                    <i class="bi bi-trash me-2"></i>Hapus Pengguna
                </button>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form id="delete-form" 
              action="{{ route('admin.users.destroy', $user->id) }}" 
              method="POST" 
              style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling;
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

@endsection