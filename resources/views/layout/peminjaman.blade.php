<head>
    @include('partials.head')
    <style>
        #peminjaman {
         background:white
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex w-full">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Konten Utama -->
        <main class=" w-full mx-8">
            @yield('content')
        </main>
    </div>
</body>

</html>
