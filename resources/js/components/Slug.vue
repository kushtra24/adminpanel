<template>
    <div class="slug-wrapper">
        <i class="fas fa-link"></i>
        <span>{{ url }}/{{ subDirectory }}/</span>
        <span class="slug" v-show="title && !isEditing" style="margin-left: -3px" @click="editSlug">{{ article.slug }}</span>
        <input type="text" name="slug-edit" class="input is-small" v-show="isEditing" v-model="title">
        <button class="btn btn-outline-dark btn-sm" v-show="!isEditing" @click.prevent="editSlug">Edit</button>
        <button class="btn btn-outline-dark btn-sm" v-show="isEditing" @click.prevent="saveSlug">save</button>
    </div>
</template>

<script>
// import slug from 'slug';

import {mapGetters} from "vuex";

export default {
name: "Slug",
    props: {
        title: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        subDirectory: {
          type: String,
          required: true
        },
    },
    data() {
        return {
            isEditing: false
        }
    },
    methods: {
        /**
         * convert title to slug
         * @returns {*}
         */
        convertTitle() {
            let slug = Slug(this.title)
            this.$store.dispatch('UPDATE_SLUG', slug)
            // return slug;
        },
        /**
         * edit slug
         */
        editSlug() {
            this.isEditing = true;
        },
        /**
         * save slug
         */
        saveSlug() {
            this.isEditing = false;
        }
    },
    computed: {
        // get user from store
        ...mapGetters(["article"])
    },
    watch: {
        /**
         * watching the title
         */
        title() {
            this.convertTitle();
        }
    }
}

</script>

<style scoped>

</style>
