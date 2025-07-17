<head>
    @include('partials.head')
    <style>
        #peminjaman {
            background: white
        }
    </style>
</head>

<body class="bg-gray-100 h-screen overflow-hidden">
    <div class="flex w-full h-full">
        <!-- Sidebar -->
        @include('partials.sidebar_pengguna')

        <!-- Konten Utama -->
        <main class="flex-1 p-8 overflow-y-auto h-full scrollbar-hide">
            @yield('content')
        </main>
    </div>
</body>

</html>
