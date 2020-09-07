<template>
<div>
    <PageHeader title="Blog" />

    <div class="container">
        <p>{{ $t('main.message', {company: 'localise'})}}</p>
        <p>{{ $tc('main.new_message', 10)}}</p>
        <p>{{ $d(new Date(), 'short') }}</p>
    </div>
</div>
</template>

<script>
import PageHeader from "../../components/PageHeader";

export default {
name: "blogComponent",
    components: {
        PageHeader
    }
}
</script>
