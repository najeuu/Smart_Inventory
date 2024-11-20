<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
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
