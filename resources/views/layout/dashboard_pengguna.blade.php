<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head') {{-- Include head dengan meta, CSS, dsb --}}
    <style>
        #dashboard {
            background: white;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        {{-- Sidebar pengguna --}}
        @include('partials.sidebar_pengguna')

        {{-- Konten utama --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>

