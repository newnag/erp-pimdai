<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ERP PIMDAI') }} - @yield('title', 'Dashboard')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            @include('components.header')

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
