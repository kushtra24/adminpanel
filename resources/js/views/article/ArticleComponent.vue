<template>
<div class="wrapper" v-if="$gate.isAdmin()">
    <!-- Content Header (Page header) -->
    <pageHeader title="Articles" />
    <router-link to="/article-create" type="a" class="btn btn-success margin-small">Create Article</router-link>

    <div class="container-fluid">

        <div class="box margin-top-medium">
            <!-- loading spinner-->
            <Spinner v-if="loading" />

            <div id="users-container" v-if="!loading">
<!--                <form @submit.prevent="fetchFilteredUsers">-->
<!--                    <div class="form-filters row">-->
<!--                        &lt;!&ndash; SEARCH FORM @input="searchUser" &ndash;&gt;-->
<!--                        <div class="input-group col-sm-3">-->
<!--                            <input class="form-control" type="search" placeholder="Search" aria-label="Search" v-model="filter.search" >-->
<!--                        </div>-->
<!--                        &lt;!&ndash; filter type  @input="filterUser"&ndash;&gt;-->
<!--                        <div class="form-group col-sm-2">-->
<!--                            <select name="type" id="type" v-model="filter.type" type="type" class="form-control" >-->
<!--                                <option value=""> Select User Role</option>-->
<!--                                <option value="admin">Admin</option>-->
<!--                                <option value="user"> Standard user</option>-->
<!--                                <option value="author">Author</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="submit-button margin-small-right">-->
<!--                        <button type="submit" class="btn btn-primary">Submit</button>-->
<!--                        </div>-->
<!--                        <div class="clear-filters-button" v-bind:class="{ 'hidden': !filter.type && !filter.search}">-->
<!--                        <button @click="clearFilters" class="btn btn-danger">Clear</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->


                <Spinner v-if="searchLoading" class=" spinner-color-black" />
                <div v-if="!searchLoading">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">title</th>
                            <th scope="col">content</th>
                            <th scope="col">created At</th>
                            <th scope="col">Public</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="article in articles.data" :key="article.id" v-bind:class="{ 'table-secondary': !article.public }" >
                            <th scope="row">article.id</th>
                            <td>{{ article.title }}</td>
                            <td>{{ article.content | str_limit(15) }}</td>
                            <td>{{ article.created_at }}</td>
                            <td>{{ article.public }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <pagination :data="articles" @pagination-change-page="fetchFilteredUsers">
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
                id: this.$route.params.id,
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
             * Fetch paginated Data
             */
            // fetchPaginatedData(page = 1) {
            //     this.searchLoading = true;
            //     this.$store.dispatch('FETCH_FILTERED_USERS', page)
            //         .then(() => {
            //             // if (data.data.length === 0) {
            //             this.searchLoading = false
            //             // }
            //         }).catch(() => {
            //             this.searchLoading = false
            //             console.log('Fetching Filtered users in users component failed')
            //         }
            //     );
            // },

            /**
             * FetchFilteredUSers
             */
            fetchFilteredUsers(page = 1) {
                this.searchLoading = true;
                this.$store.dispatch('FETCH_FILTERED_USERS', page)
                    .then(() => {
                        // if (data.data.length === 0) {
                            this.searchLoading = false
                        // }
                    }).catch(() => {
                            this.searchLoading = false
                            console.log('Fetching Filtered users in users component failed')
                        }
                );
            },

            // clearFilters() {
            //     this.$store.dispatch('CLEAR_USER_FILTERS');
            // },

            /**
             * navigate to Edit
             */
            navigateToEdit(id) {
                this.$router.push({path: `/article-details/${id}` });
            }
        },
        computed: {
            ...mapGetters(["articles", "filter"]),
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
