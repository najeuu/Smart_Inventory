<head>
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
            @include('partials.sidebar')
        </div>
        <!-- Konten Utama -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>

</html>
