<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark inline-block">{{ title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
<!--                        <li class="breadcrumb-item" v-for="value in pages" :key="value">-->
<!--                            <router-link to="/{{ value }}">{{ value }}</router-link>-->
<!--                        </li>-->
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</template>

<script>
export default {
    name: "PageHeader",
    props: {
        title: '',
        // pages: { type: Array }
    }
};
</script>
