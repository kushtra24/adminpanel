<template>
    <div class="wrapper">
        <!-- Content Header (Page header) -->
        <PageHeader title="Developer" />

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
