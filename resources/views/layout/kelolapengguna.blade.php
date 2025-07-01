<head>
    @include('partials.head')
    <style>
        #kelolapengguna {
            background: white
        }
    </style>
</head>

<body class="flex bg-gray-100 overflow-hidden">
    @include('partials.sidebar')

    <!-- Konten Utama -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>
</body>
