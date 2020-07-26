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
                        <li class="breadcrumb-item" v-for="(value, index) in pages" :key="index">
<!--                            <router-link :to="{ path: '/' + value }">{{ value }} </router-link>-->
                            <span class="breadcrumb-item">{{ value }}</span>
                        </li>
                        <span class="breadcrumb-item">{{ title }}</span>
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
        pages: { type: Array }
    }
};


</script>
