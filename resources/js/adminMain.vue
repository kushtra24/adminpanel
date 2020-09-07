<template>
    <div id="nav">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link to="/profile" tag="a" class="nav-link" active-class="active" exact>
                      Profile
                    </router-link>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link to="/developer" tag="a" class="nav-link" active-class="active" exact>
                        Developer
                    </router-link>
                </li>

            </ul>

            <!-- right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/"><span @click="logout">Logout <i class="fas fa-sign-out-alt"></i> </span></a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <!--            <img src="../img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
            <span class="brand-text font-weight-light">Admin Panel</span>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <router-link to="/dashboard" tag="a" class="nav-link" active-class="active" exact>
                                <i class="nav-icon fas fa-th"></i>
                                <p>{{ $t('nav.dashboard') }}</p>
                            </router-link>
                        </li>

                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p><i class="right fas fa-angle-left"></i>Management</p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/users" tag="a" active-class="active" class="nav-link">
                                        <p>Users</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/articles" tag="a" class="nav-link" active-class="active">
                                        <p>Articles</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Simple Link
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <router-view v-bind:key="$route.fullPath"></router-view>
                </div>
            </div>
            <!-- /.content-header -->
        </div>
        <!-- /.content-wrapper -->
    </div>
</template>

<script>
export default {
name: "adminMain",
    methods: {

        logout() {
            this.$store.dispatch('LOGOUt')
            .then( () => {
                console.log('logged out');
            })
            .catch(() => {
                console.log('error logging out');
            });
        }

    }
}
</script>
