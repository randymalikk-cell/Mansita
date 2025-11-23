<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #f4f6f9;
        }

        .auth-wrapper {
            min-height: 100vh;
        }

        .auth-card {
            border-radius: 12px;
            padding: 35px;
        }

        .logo-container img {
            width: 85px;
            height: 85px;
        }
    </style>
</head>

<body>
    <div class="container auth-wrapper d-flex flex-column justify-content-center align-items-center">

        <!-- LOGO -->
        <div class="logo-container mb-4 text-center">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <!-- CARD -->
        <div class="card shadow auth-card col-12 col-md-6 col-lg-4">
            {{ $slot }}
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
