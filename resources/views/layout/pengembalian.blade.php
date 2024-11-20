<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="bg-gray-100">
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
