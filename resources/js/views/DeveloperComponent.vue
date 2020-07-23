<template>
    <div class="wrapper">
        <!-- Content Header (Page header) -->
        <PageHeader title="Developer" />

<!--        <div class="content-header">-->
<!--            <div class="container-fluid">-->
<!--                <div class="row mb-2">-->
<!--                    <div class="col-sm-6">-->
<!--                        <h1 class="m-0 text-dark">Developer</h1>-->
<!--                    </div>&lt;!&ndash; /.col &ndash;&gt;-->
<!--                    <div class="col-sm-6">-->
<!--                        <ol class="breadcrumb float-sm-right">-->
<!--                            <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>-->
<!--                            <li class="breadcrumb-item active">Developer</li>-->
<!--                        </ol>-->
<!--                    </div>&lt;!&ndash; /.col &ndash;&gt;-->
<!--                </div>&lt;!&ndash; /.row &ndash;&gt;-->
<!--            </div>&lt;!&ndash; /.container-fluid &ndash;&gt;-->
<!--        </div>-->

        <div class="row justify-content-center">
            <div class="col-md-8">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</template>

<script>
    import PageHeader from "../components/PageHeader";

    export default {
        components: {
            PageHeader
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
