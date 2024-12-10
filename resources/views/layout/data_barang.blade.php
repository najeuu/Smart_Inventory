<head>
    @include('partials.head')
    <style>
        #data_barang {
            background: white
        }
    </style>
</head>

<body class="flex overflow-hidden">
    @include('partials.sidebar')
    @yield('content')
</body>
