<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de Ventas</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="/fuentes/FredokaOne-Regular.ttf" rel="stylesheet">
    <link href="/fuentes/BowlbyOneSC-Regular.ttf" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="/fontawesome/css/all.css" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

</head>
<body id="page-top">
    <div id="app">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!--  
            <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm cabecera">
                <div class="container">
                    <a class="navbar-brand titulo-cabecera" href="{{ url('/') }}">
                        <h3 class="tex-white"><strong>Sistema de Ventas</strong></h3>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        // Left Side Of Navbar 
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        // Right Side Of Navbar
                        <ul class="navbar-nav ml-auto">
                            // Authentication Links

                        </ul>
                    </div>
                </div>
            </nav>
            -->
            

            

                        @yield('content')


        </div>
    </div>
</body>
</html>
