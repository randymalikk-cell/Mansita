<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fc;
        }

        .header-wrapper {
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    @include('layouts.navigation')

    <div class="min-vh-100">

        <!-- Page Header -->
        @isset($header)
            <header class="header-wrapper py-3 mb-4 shadow-sm">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
       <main class="container py-4">
    @yield('content')
</main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
