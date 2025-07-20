<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.head')

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            width: 0px;
            height: 0px;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-100 h-screen overflow-hidden font-poppins">
    <div class="flex w-full h-full">
        @include('partials.sidebar_pengguna')

        <main class="flex-1 p-8 overflow-y-auto h-full scrollbar-hide">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/rfid-scanner-laravel.js') }}"></script>
    @stack('scripts')
</body>
</html>
