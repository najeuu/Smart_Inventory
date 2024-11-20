<head>
    @include('partials.head')
    <style>
        #data_barang{
         background:white
        }
    </style>
</head>

<body class="flex ">
        @include('partials.sidebar')
        @yield('content')
</body>
