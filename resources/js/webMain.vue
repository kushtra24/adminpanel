<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Kushtrim.net</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <router-link to="/" tag="a" class="nav-link" active-class="active" exact>
                            <i class="fas fa-home"></i>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'blog', params: {lang: this.$i18n.locale} }" tag="a" class="nav-link" active-class="active" exact>
                            {{ $t('nav.blog')}}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'me', params: {lang: this.$i18n.locale} }" tag="a" class="nav-link" active-class="active" exact>
                            {{ $t('nav.about')}}
                        </router-link>
                    </li>
                </ul>
                <ul class="navbar-nav form-inline my-2 my-lg-0">
                    <li>
                        <LocaleSwitcher />
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/login"><span >Login <i class="fas fa-sign-in-alt"></i> </span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div>
            <div class="content">
                <div class="container-fluid">
                    <router-view class="web view" name="web"></router-view>
                </div>
            </div>
            <!-- /.content-header -->
        </div>
        <!-- /.content-wrapper -->
    </div>
</template>

<script>
import LocaleSwitcher from "./components/LocaleSwitcher";

export default {
name: "webMain",
    components: {
        LocaleSwitcher
    }
}
</script>
