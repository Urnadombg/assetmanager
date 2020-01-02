<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{--        <meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" integrity="sha256-zmfNZmXoNWBMemUOo1XUGFfc0ihGGLYdgtJS3KCr/l0=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/css/sb-admin-2.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/css/sb-admin-2.css">

    {{--        <!-- Styles -->--}}
    {{--        <link rel="stylesheet" href="node_modules/@coreui/coreui/dist/css/coreui.min.css">--}}

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Дентакон</a>
        <button class="navbar-toggler" type="button"
                data-toggle="collapse"
                data-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @if (Route::has('login'))

                @auth
                <li class="nav-item"><a href="{{ url('/home') }}">Home</a></li>
                @else
                <li class="nav-item">
                    <a href="{{ route('login') }}">Login</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a href="{{ route('register') }}">Register</a>
                </li>
                @endif
                @endauth
            </ul>
            @endif

            {{--                <ul class="navbar-nav">--}}
                {{--                    <li class="nav-item active">--}}
                    {{--                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                    {{--                    </li>--}}
                {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="#">Features</a>--}}
                    {{--                    </li>--}}
                {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="#">Pricing</a>--}}
                    {{--                    </li>--}}
                {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link disabled" href="#">Disabled</a>--}}
                    {{--                    </li>--}}
                {{--                </ul>--}}
        </div>
    </nav>

        @yield('content')

</div>
</body>
</html>
