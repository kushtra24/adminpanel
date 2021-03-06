{{--<!DOCTYPE html>--}}
{{--<!----}}
{{--This is a starter template page. Use this page to start your new project from--}}
{{--scratch. This page gets rid of all links and provides the needed markup only.--}}
{{---->--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <meta http-equiv="x-ua-compatible" content="ie=edge">--}}
{{--    <link rel="icon" href="data:;base64,iVBORw0KGgo=">--}}

{{--    <!-- CSRF Token -->--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--    <title>Kushtrim.net</title>--}}

{{--    <link rel="stylesheet" href="/css/app.css">--}}

{{--    <!-- Scripts -->--}}
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

{{--    @auth--}}
{{--        <script>--}}
{{--            window.user = @json(auth()->user())--}}
{{--        </script>--}}
{{--    @endauth--}}

{{--</head>--}}
{{--<body class="hold-transition sidebar-mini">--}}
{{--<div class="wrapper" id="app">--}}
{{--    <LocaleSwitcher/>--}}
{{--    <MainMenu/>--}}
{{--    <router-view v-bind:key="$route.fullPath"></router-view>--}}

{{--    <!-- Navbar -->--}}
{{--    <nav class="main-header navbar navbar-expand navbar-white navbar-light">--}}
{{--        <!-- Left navbar links -->--}}
{{--        <ul class="navbar-nav">--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>--}}
{{--            </li>--}}
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="/" class="nav-link">Home</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <router-link to="/profile" tag="a" class="nav-link" active-class="active" exact class="nav-link">--}}
{{--                    {{ Auth::user()->name }}--}}
{{--                </router-link>--}}
{{--            </li>--}}
{{--            @can('isAdmin')--}}
{{--                <li class="nav-item d-none d-sm-inline-block">--}}
{{--                    <router-link to="/developer" tag="a" class="nav-link" active-class="active" exact class="nav-link">--}}
{{--                        Developer--}}
{{--                    </router-link>--}}
{{--                </li>--}}
{{--            @endcan--}}

{{--        </ul>--}}

{{--        <!-- right navbar links -->--}}
{{--        <ul class="navbar-nav ml-auto">--}}
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a class="nav-link" href="{{ route('logout') }}"--}}
{{--                   onclick="event.preventDefault();--}}
{{--                        document.getElementById('logout-form').submit();">--}}
{{--                    {{ __('Logout') }}--}}
{{--                </a>--}}

{{--                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                    @csrf--}}
{{--                </form>--}}
{{--            </li>--}}
{{--        </ul>--}}

{{--    </nav>--}}
{{--    <!-- /.navbar -->--}}

{{--    <!-- Main Sidebar Container -->--}}
{{--    <aside class="main-sidebar sidebar-dark-primary elevation-4">--}}
{{--        <!-- Brand Logo -->--}}
{{--        <a href="index3.html" class="brand-link">--}}
{{--            <img src="../img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
{{--            <span class="brand-text font-weight-light">Admin Panel</span>--}}
{{--        </a>--}}

{{--        <!-- Sidebar -->--}}
{{--        <div class="sidebar">--}}
{{--            <!-- Sidebar Menu -->--}}
{{--            <nav class="mt-2">--}}
{{--                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"--}}
{{--                    data-accordion="false">--}}
{{--                    <!-- Add icons to the links using the .nav-icon class--}}
{{--                         with font-awesome or any other icon font library -->--}}

{{--                    <li class="nav-item">--}}
{{--                        <router-link to="/dashboard" tag="a" class="nav-link" active-class="active" exact--}}
{{--                                     class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-th"></i>--}}
{{--                            <p>--}}
{{--                                  dashboard  --}}{{----}}{{--{{ $t('menu.dashboard') }}--}}
{{--                            </p>--}}
{{--                        </router-link>--}}
{{--                    </li>--}}
{{--                    @can('isAdmin')--}}
{{--                        <li class="nav-item has-treeview menu-open">--}}
{{--                            <a href="#" class="nav-link">--}}
{{--                                <i class="nav-icon fas fa-tachometer-alt"></i>--}}
{{--                                <p><i class="right fas fa-angle-left"></i>Management</p>--}}
{{--                            </a>--}}
{{--                            <ul class="nav nav-treeview">--}}
{{--                                <li class="nav-item">--}}
{{--                                    <router-link to="/users" tag="a" active-class="active" class="nav-link">--}}
{{--                                        <p>Users</p>--}}
{{--                                    </router-link>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <router-link to="/articles" tag="a" class="nav-link" active-class="active">--}}
{{--                                        <p>Articles</p>--}}
{{--                                    </router-link>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endcan--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="#" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-th"></i>--}}
{{--                            <p>--}}
{{--                                Simple Link--}}
{{--                                <span class="right badge badge-danger">New</span>--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </nav>--}}
{{--            <!-- /.sidebar-menu -->--}}
{{--        </div>--}}
{{--        <!-- /.sidebar -->--}}
{{--    </aside>--}}

{{--    <!-- Content Wrapper. Contains page content -->--}}
{{--    <div class="content-wrapper">--}}
{{--        <div class="content">--}}
{{--            <div class="container-fluid">--}}
{{--                <router-view v-bind:key="$route.fullPath"></router-view>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.content-header -->--}}
{{--    </div>--}}
{{--    <!-- /.content-wrapper -->--}}

{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

{{--<script>--}}
{{--    import MainMenu from "../../js/components/MainMenu";--}}
{{--    import LocaleSwitcher from "../../js/components/LocaleSwitcher";--}}

{{--    export default {--}}
{{--        components: {--}}
{{--            MainMenu,--}}
{{--            LocaleSwitcher--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}
