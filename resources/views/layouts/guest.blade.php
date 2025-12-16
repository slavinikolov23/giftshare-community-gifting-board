<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GiftShare') }} - @yield('title', 'Community Gifting Board')</title>
        <meta name="description" content="GiftShare - Общностна дъска за подаръци. Публикувайте вещи, които подарявате безплатно.">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <!-- Livewire Styles -->
        @livewireStyles
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .auth-card {
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                padding: 2rem;
                width: 100%;
                max-width: 450px;
            }
            .auth-logo {
                text-align: center;
                margin-bottom: 2rem;
            }
            .auth-logo a {
                color: #667eea;
                text-decoration: none;
                font-size: 2rem;
                font-weight: 700;
            }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <div class="auth-logo">
                <a href="{{ route('items.index') }}">
                    <i class="bi bi-gift-fill me-2"></i>GiftShare
                </a>
            </div>

            {{ $slot }}
        </div>

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- Livewire Scripts -->
        @livewireScripts
    </body>
</html>
