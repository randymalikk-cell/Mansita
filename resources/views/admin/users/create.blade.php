@extends('layouts.app')

@section('content')

<header class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Tambah Pengguna Baru</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<h2>
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('admin.users.index') }}" class="breadcrumb-link">Manajemen Pengguna</a>
    > <span style="color:#27d436ff; font-weight:700;">Tambah Pengguna Baru</span>
</h2>

<div class="container-fluid px-0">
    
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <div class="form-header-content">
                <h2>Form Data Pengguna</h2>
                <p>Lengkapi informasi pengguna baru dengan benar</p>
            </div>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
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
                               value="{{ old('nama') }}" 
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
                               value="{{ old('username') }}" 
                               placeholder="Masukkan username"
                               required>
                        <small class="form-text">Username akan digunakan untuk login</small>
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
                               value="{{ old('email') }}"
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
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                👑 Admin
                            </option>
                            <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>
                                👤 Pengurus
                            </option>
                            <option value="staf produksi" {{ old('role') == 'staf produksi' ? 'selected' : '' }}>
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
                            Password<span class="required">*</span>
                        </label>
                        <div class="password-wrapper">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('password')"></i>
                        </div>
                        <small class="form-text">Minimal 8 karakter, kombinasi huruf dan angka</small>
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
                            Konfirmasi Password<span class="required">*</span>
                        </label>
                        <div class="password-wrapper">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password"
                                   required>
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('password_confirmation')"></i>
                        </div>
                        <small class="form-text">Ketik ulang password yang sama</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Simpan Pengguna
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
            </div>
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