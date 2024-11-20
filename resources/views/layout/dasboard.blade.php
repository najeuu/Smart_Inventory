<head>
    @include('partials.head')
</head>

<body>
    <div class="flex bg-gray-100">
        @include('partials.sidebar')

        @yield('content')
    </div>

</body>
