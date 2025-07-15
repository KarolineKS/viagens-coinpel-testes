<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="app-layout">
        @include('layouts.partials.sidebar')

        <div class="main-content">
            @include('layouts.partials.header')

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        @if (session('success'))
        <x-toast type="success" :message="session('success')" />
        @endif

        @if (session('error'))
        <x-toast type="danger" :message="session('error')" />

        @elseif ($errors->any() && !session('show_validation_error_alert'))
        <x-toast type="danger" message="Erro no formulário! Verifique os campos destacados." />
        @endif

        @if (session('warning'))
        <x-toast type="warning" :message="session('warning')" />
        @endif

        @if (session('info'))
        <x-toast type="info" :message="session('info')" />
        @endif
    </div>

    @if (session('alert_error'))
    <x-custom-alert type="error" :message="session('alert_error')" />
    @elseif (session('alert_warning'))
    <x-custom-alert type="warning" :message="session('alert_warning')" />
    @elseif (session('alert_info'))
    <x-custom-alert type="info" :message="session('alert_info')" />
    @endif

    @stack('scripts')
</body>

</html>