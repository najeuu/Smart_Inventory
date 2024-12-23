<head>
    @include('partials.head')
    <style>
        #data_barang {
         background:white
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex w-full">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Konten Utama -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>

</html>
