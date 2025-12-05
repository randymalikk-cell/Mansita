@extends('layouts.app')

@section('content')
<style>
    .summary-card {
        border-radius: 16px;
        padding: 22px;
        background: #ffffff;
        box-shadow: 0 3px 8px rgba(0,0,0,0.06);
    }
    .status-aman {
        background: #E8F8EF;
        color: #16A34A;
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
    }
    .status-rendah {
        background: #FDEAEC;
        color: #DC2626;
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
    }
    .table thead {
        background: #F8FAFC;
        font-weight: bold;
    }
</style>

<div class="container-fluid p-4">

    <!-- Judul -->
    <h3 class="fw-bold mb-4">Manajemen Stok</h3>

    <!-- Ringkasan Stok -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="summary-card">
                <p class="text-secondary mb-1">Total Stok</p>
                <h2 class="fw-bold">{{ $totalStok }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card">
                <p class="text-secondary mb-1">Tahu Putih</p>
                <h2 class="fw-bold">{{ $totalPutih }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card">
                <p class="text-secondary mb-1">Tahu Kuning</p>
                <h2 class="fw-bold">{{ $totalKuning }}</h2>
            </div>
        </div>

        

    </div>

    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-body">

            <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari produk..." 
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="jenis" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="putih" {{ request('jenis')=='putih'?'selected':'' }}>Tahu Putih</option>
                        <option value="kuning" {{ request('jenis')=='kuning'?'selected':'' }}>Tahu Kuning</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

            </form>

        </div>
    </div>

    <!-- Tabel -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white fw-bold" style="border-radius: 16px 16px 0 0;">
            Daftar Stok Produk
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Jumlah</th>
                        <th>Tanggal Update</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($stoks as $stok)
                        <tr>
                            

                            <td>{{ $stok->updated_at->format('d M Y, H:i') }}</td>

                            <td>
                                <span class="status-aman">Stok Aman</span>
                            </td>

                            <td>
                                <a href="#" class="text-primary me-2">✏️</a>
                                <a href="#" class="text-success me-2">👁️</a>
                                <a href="#" class="text-danger">🗑️</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
