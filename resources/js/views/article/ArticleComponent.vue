<template>
<div class="wrapper" v-if="$gate.isAdmin()">
    <!-- Content Header (Page header) -->
    <pageHeader title="Articles" :pages="['Dashboard']" />
    <router-link to="/articles-create" type="a" class="btn btn-success margin-small">Create Article</router-link>

    <div class="container-fluid">
        <div class="box margin-top-medium">
            <!-- loading spinner-->
            <Spinner v-if="loading" />

            <div id="users-container" v-if="!loading">
                <Spinner v-if="searchLoading" class=" spinner-color-black" />
                <div v-if="!searchLoading">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">created At</th>
                            <th scope="col">Updated At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="article in articles.data" :key="article.id" v-bind:class="{ 'table-secondary': !article.public }"
                            @click="navigateToEdit(article.slug)">
                            <th scope="row">{{ article.id }}</th>
                            <td>{{ article.title }}</td>
                            <td>{{ article.content | str_limit(15) }}</td>
                            <td>{{ article.created_at | euDate }}</td>
                            <td>{{ article.updated_at | euDate }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <pagination :data="articles" @pagination-change-page="fetchFilteredArticles">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
          </div>
    </div>


</div>
</template>

<script>
import {mapGetters} from "vuex";
import Spinner from "../../components/Spinner";
import pageHeader from "../../components/PageHeader";
import pagination from "laravel-vue-pagination"

    export default {
        components: {
            Spinner,
            pageHeader,
            pagination
        },
        data() {
            return {
                loading: false,
                searchLoading: '',
            }
        },

        methods: {
            /**
             * fetch all users
             */
            fetchAllArticles(context, page = 1) {
                this.loading = true;
                this.$store.dispatch('FETCH_ALL_ARTICLES', page)
                    .then(() => this.loading = false)
                    .catch(() => {
                        this.loading = false
                        console.log('Fetching Filtered users in users component failed')
                    }  );
            },

            /**
             * FetchFilteredUSers
             */
            fetchFilteredArticles(page = 1) {
                this.searchLoading = true;
                this.$store.dispatch('FETCH_FILTERED_ARTICLES', page)
                    .then(() => {
                        // if (data.data.length === 0) {
                            this.searchLoading = false
                        // }
                    }).catch(() => {
                            this.searchLoading = false
                            console.log('Fetching Filtered Articles failed')
                        }
                );
            },

            // clearFilters() {
            //     this.$store.dispatch('CLEAR_USER_FILTERS');
            // },

            /**
             * navigate to Edit
             */
            navigateToEdit(slug) {
                this.$router.push({path: `/articles/${slug}` });
            }
        },
        computed: {
            ...mapGetters(["articles"]),
        },
        created() {
            if (this.$gate.isAdmin()) {
                // this.getResults();
                this.fetchAllArticles();
            } else {
                this.$router.push({path: `/dashboard` });
            }
        }
    }
</script>
