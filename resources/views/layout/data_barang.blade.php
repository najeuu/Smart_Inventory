<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.head')
    <style>
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        body, main {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-100 font-poppins overflow-x-hidden">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 fixed h-screen bg-white shadow-lg z-40">
            @include('partials.sidebar')
        </div>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col ml-64 min-h-screen">
            <!-- Header -->
            <div class="fixed top-0 left-64 right-0 h-16">
                @include('partials.header')
            </div>

            <!-- Isi Konten -->
            <main class="flex-1 pt-20 p-8 overflow-y-auto scrollbar-hide" style="height: calc(100vh - 64px);">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
