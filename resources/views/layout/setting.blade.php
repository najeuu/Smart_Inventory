<head>
    @include('partials.head')
    <style>
        #setting{
         background:white
        }
    </style>
</head>

<body class="flex bg-gray-100 flex-box overflow-visible">
    @include('partials.sidebar')

    <!-- Konten Utama -->
    @yield('content')
</body>

