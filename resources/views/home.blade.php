<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="icon" href="data:;base64,iVBORw0KGgo=">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kushtrim.net</title>

        <link rel="stylesheet" href="/css/app.css">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        @auth
            <script>
                window.user = @json(auth()->user())
            </script>
        @endauth

    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper" id="app">
            <admin-main/>
        </div>
    </body>
</html>
