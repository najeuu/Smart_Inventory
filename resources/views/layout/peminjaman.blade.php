<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="bg-gray-100 flex">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Konten Utama -->
        <main class="p-4 items-center justify-center bg-red-400">
            @yield('content')
        </main>
    </div>
</body>

</html>
