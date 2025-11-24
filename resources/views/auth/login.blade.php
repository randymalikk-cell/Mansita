<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Pabrik Tahu</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
        }
        .left-panel {
            background: linear-gradient(160deg, #0c8f53, #0aa067);
            height: 100vh;
            color: white;
            padding: 60px;

            display: flex;
            flex-direction: column;
            justify-content: center;   /* center vertikal */
            align-items: center;        /* center horizontal */
            text-align: center;
        }

        .left-panel h2 {
            font-weight: 700;
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 16px;

            display: flex;
            align-items: center;     /* center vertical */
            justify-content: center; /* center horizontal */
            

            margin-bottom: 20px;
        }
        .right-panel {
            padding: 50px 70px;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- LEFT GREEN PANEL -->
        <div class="col-md-6 d-flex flex-column justify-content-center left-panel">

            <div class="icon-box">
                <img src="{{ asset('icons/factory.png') }}" 
                    alt="factory" 
                    style="width: 48px; height: 48px;">
            </div>


            <h2>Sistem Manajemen Pabrik Tahu</h2>
            <p class="mt-3">Kelola produksi tahu dengan efisien dan modern.</p>

            <div class="mt-4">
                <div class="row g-3">
                    <div class="col-6">
                        <button class="btn btn-light w-100 py-3 d-flex flex-column align-items-center">
                            <img src="{{ asset('icons/chart.png') }}" 
                                alt="chart" 
                                style="width: 30px; height: 30px; margin-bottom: 6px;">
                            <span>Analisa Bahan Baku</span>
                        </button>
                    </div>

                    <div class="col-6">
                            <button class="btn btn-light w-100 py-3 d-flex flex-column align-items-center">
                                <img src="{{ asset('icons/ready-stock.png') }}" 
                                    alt="stock" 
                                    style="width: 30px; height: 30px; margin-bottom: 6px;">
                                <span>Manajemen Stok</span>
                            </button>
                    </div>

                    <div class="col-6">
                        <button class="btn btn-light w-100 py-3 d-flex flex-column align-items-center">
                            <img src="{{ asset('icons/customer.png') }}" 
                                alt="customer" 
                                style="width: 30px; height: 30px; margin-bottom: 6px;">
                            <span>Data Pelangggan</span>
                        </button>
                    </div>

                    <div class="col-6">
                        <button class="btn btn-light w-100 py-3 d-flex flex-column align-items-center">
                            <img src="{{ asset('icons/report.png') }}" 
                                alt="report" 
                                style="width: 30px; height: 30px; margin-bottom: 6px;">
                            <span>Laporan Produksi</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>

        <!-- RIGHT LOGIN PANEL -->
        <div class="col-md-6 d-flex align-items-center right-panel">
            <div class="login-card w-100">

                <h3 class="text-center mb-4">Selamat Datang</h3>
                <p class="text-center text-muted">Masuk ke akun Anda untuk melanjutkan</p>

                <!-- FORM LOGIN -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input id="email" type="email" name="email" class="form-control" placeholder="Masukkan username">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password">
                    </div>

                    <!-- Remember me -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none">Lupa password?</a>
                    </div>

                    <!-- Button -->
                    <button type="submit" class="btn btn-success w-100 py-2">Masuk ke Sistem</button>

                    <p class="text-center text-muted mt-3" style="font-size: 12px;">
                        Sistem Manajemen Pabrik Tahu © 2025 — Semua Hak Dilindungi
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>


</body>
</html>
