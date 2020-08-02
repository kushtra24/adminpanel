<template>
<div class="categories">
        <!-- loading spinner-->
        <spinner v-if="loading" />
        <div class="form-check" v-for="category in categories" :key="category.id" v-if="!loading">
            <input class="form-check-input" type="checkbox" :value="category.id" :id="category.name" v-model="article.cat">
            <label class="form-check-label" :for="category.name">
                {{ category.name }}
            </label>
        </div>
</div>
</template>

<script>
import {mapGetters} from "vuex";
import spinner from "./spinner";

export default {
name: "category",
    components: {
        spinner
    },
    beforeDestroy() {
            // reset state of user
            this.$store.dispatch("RESET_CATEGORIES_STATE");
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        /**
         * fetch all users
         */
        fetchCategories(context) {
            this.loading = true;
            this.$store.dispatch('FETCH_CATEGORIES')
                .then(() => this.loading = false)
                .catch(() => {
                    this.loading = false
                    console.log('Fetching categories failed')
                }  );
        },
    },
    created() {
        if (this.$gate.isAdmin()) {
            // this.getResults();
            this.fetchCategories();
        } else {
            this.$router.push({path: `/dashboard` });
        }
    },
    computed: {
        // get user from store
        ...mapGetters(["article", 'categories']),

    },
}
</script>
