<head>
    @include('partials.head')
    <style>
        #peminjaman {
            background: white
        }
    </style>
</head>

<body class="bg-gray-100 overflow-hidden">
    <div class="flex w-full">
        <!-- Sidebar -->
        @include('partials.sidebar_pengguna')

        <!-- Konten Utama -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>

</html>
