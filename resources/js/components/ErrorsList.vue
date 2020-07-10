<template v-show="errors">
    <ul class="error-messages">
        <li v-for="(value, key) in errors" :key="key">
            <i class="fas fa-exclamation-triangle fa-fw"></i>
            <!-- <span v-text="key" />-->
            <span v-for="err in value" :key="err" v-text="err" />
        </li>
    </ul>
</template>

<script>
export default {
    name: "ErrorsList",
    props: {
        errors: { type: Object, required: true }
    }
};
</script>
