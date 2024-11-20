<head>
    @include('partials.head')
</head>

<body class="flex bg-gray-100">
    @include('partials.sidebar')

  <!-- Konten Utama -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>
</body>
