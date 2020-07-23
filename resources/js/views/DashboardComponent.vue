<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <PageHeader title="Dashboard" />

    <!--    <div class="content-header">-->
<!--      <div class="container-fluid">-->
<!--        <div class="row mb-2">-->
<!--          <div class="col-sm-6">-->
<!--            <h1 class="m-0 text-dark">Dashboard</h1>-->
<!--          </div>&lt;!&ndash; /.col &ndash;&gt;-->
<!--          <div class="col-sm-6">-->
<!--            <ol class="breadcrumb float-sm-right">-->
<!--              <li class="breadcrumb-item"><a href="#">Home</a></li>-->
<!--              <li class="breadcrumb-item active">dashboard</li>-->
<!--            </ol>-->
<!--          </div>&lt;!&ndash; /.col &ndash;&gt;-->
<!--        </div>&lt;!&ndash; /.row &ndash;&gt;-->
<!--      </div>&lt;!&ndash; /.container-fluid &ndash;&gt;-->
<!--    </div>-->

    <div class="conta">

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
