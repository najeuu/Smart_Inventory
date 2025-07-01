<head>
    @include('partials.head')
    <style>
        #kategori {
            background: white
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-md z-40">
        @include('partials.sidebar')
    </aside>

    <!-- Konten Utama -->
    <main class="ml-64 p-8 overflow-auto min-h-screen">
        @yield('content')
    </main>
</body>
