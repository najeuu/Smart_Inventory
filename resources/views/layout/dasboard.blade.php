<head>
    @include('partials.head')
</head>

<body>
    <div class="flex">
        @include('partials.sidebar')

        @yield('content')
    </div>

</body>
