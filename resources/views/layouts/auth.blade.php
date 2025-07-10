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
    <div class="toast-container position-fixed top-0 end-0 p-3">
        @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    @if (session('error'))
    <x-custom-alert type="error" :message="session('error')" />
    @elseif (session('info'))
    <x-custom-alert type="warning" :message="session('warning')" />
    @endif

    @stack('scripts')
</body>

</html>