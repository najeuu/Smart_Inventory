@include('partials.head')

<body class="bg-gray-100 font-poppins overflow-x-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('partials.header')

            <!-- Konten -->
            <main class="flex-1 p-8 h-full">
            <div class="h-full">
                @yield('content')
            </div>
            </main>
        </div>
    </div>
</body>
