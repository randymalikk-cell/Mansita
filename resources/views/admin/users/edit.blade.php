@extends('layouts.app')

@section('content')

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