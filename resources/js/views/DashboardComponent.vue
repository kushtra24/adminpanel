<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <PageHeader title="Dashboard" />
    <LocaleSwitcher />
    <div class="container">
        <p>{{ $t('main.message', {company: 'localise'})}}</p>
        <p>{{ $tc('main.new_message', 10)}}</p>
        <p>{{ $d(new Date(), 'short') }}</p>
    </div>
</div>
</template>

<script>
    import PageHeader from "../components/PageHeader";
    import LocaleSwitcher from "../components/LocaleSwitcher";

    export default {
        components: {
            PageHeader,
            LocaleSwitcher
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
