<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.head')

    <!-- Custom hide-scrollbar class -->
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

<body class="bg-gray-100 h-screen w-screen overflow-hidden font-poppins">
    <div class="flex h-screen w-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-[250px] h-full overflow-y-auto hide-scrollbar bg-blue-100">
            @include('partials.sidebar_pengguna')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 h-full overflow-y-scroll scrollbar-hide p-6">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/rfid-scanner-laravel.js') }}"></script>
    @stack('scripts')
</body>
</html>
