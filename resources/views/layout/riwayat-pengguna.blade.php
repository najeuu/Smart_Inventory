<head>
    @include('partials.head')
    <style>
        #riwayat {
            background: white
        }
    </style>
</head>

<body class="flex bg-gray-100 overflow-hidden">
    @include('partials.sidebar_pengguna')

    <!-- Konten Utama -->
    <main class="flex-1 p-8 overflow-y-auto scrollbar-hide">
        @yield('content')
    </main>
</body>
