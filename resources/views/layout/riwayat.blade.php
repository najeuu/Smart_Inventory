<head>
    @include('partials.head')
    <style>
        #riwayat {
            background: white;
        }
    </style>
</head>

<body class="bg-gray-100 font-poppins overflow-x-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen">
            <!-- Header -->
            @include('partials.header')

            <!-- Konten -->
            <main class="flex-1 overflow-y-auto p-8 scrollbar-hide">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
