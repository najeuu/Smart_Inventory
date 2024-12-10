<head>
    @include('partials.head')
    <style>
        #dashboard {
            background: white
        }
    </style>
</head>

<body class="overflow-hidden">
    <div class="flex bg-gray-100">
        @include('partials.sidebar')

        @yield('content')
    </div>

</body>
