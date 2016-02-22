<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-startup-image" href="/startup.png">

    <title>Budget - @yield('pagetitle')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/datatables-responsive.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    @yield('srcstyle')

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        @yield('style')
    </style>
</head>
<body id="app-layout">
        @include('layouts.nav')

        <div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }} fade in">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
    </div> <!-- end .flash-message -->
    <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ elixir('js/vendor.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
    @yield('srcscript')
    <script>
    @yield('script')
    </script>
</body>
</html>
