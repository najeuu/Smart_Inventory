<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.head')
    <style>
        #pengembalian {
            background: white
        }
    </style>
</head>

<body class="bg-gray-100 overflow-hidden">
    <div class="flex">
        <!-- Sidebar -->
        <div class="min-h-screen h-full">
            @include('partials.sidebar_pengguna')
        </div>
        <!-- Konten Utama -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/rfid-scanner-laravel.js') }}"></script>
</body>

</html>
@section('scripts')
    @stack('scripts')
@endsection
