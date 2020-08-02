<template>
    <div class="wrapper" v-if="$gate.isAdmin()">
        <!-- Content Header (Page header) -->
        <pageHeader title="Users" :pages="['Dashboard']" />
        <router-link to="/users-create" type="a" class="btn btn-success margin-small">Create User</router-link>

        <div class="container-fluid">


            <div class="box">
                <!-- loading spinner-->
                <Spinner v-if="loading" />

                <div id="users-container" v-if="!loading" >
                    <form @submit.prevent="fetchFilteredUsers">
                        <div class="form-filters row">
                            <!-- SEARCH FORM @input="searchUser" -->
                            <div class="input-group col-sm-3">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search" v-model="filter.search" >
                            </div>
                            <!-- filter type  @input="filterUser"-->
                            <div class="form-group col-sm-2">
                                <select name="type" id="type" v-model="filter.type" type="type" class="form-control" >
                                    <option value=""> Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user"> Standard user</option>
                                    <option value="author">Author</option>
                                </select>
                            </div>
                            <div class="submit-button margin-small-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="clear-filters-button" v-show="filter.type || filter.search">
                                <button @click="clearFilters" class="btn btn-danger">Clear</button>
                            </div>
                        </div>
                    </form>


                    <Spinner v-if="searchLoading" class=" spinner-color-black" />
                    <pagination :data="users" @pagination-change-page="fetchFilteredUsers">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <div class="users-cards" v-if="!searchLoading">
                        <div class="card user-card" v-for="user in users.data" :key="user.id" @click="navigateToEdit(user.id)" v-bind:class="{ 'border-danger ': !user.active }">
                            <img v-if="!user.photo" :src="'./img/profile.png'" class="card-img-top" alt="no image">
                            <img v-if="user.photo" :src="'./storage/user/' + user.photo" class="card-img-top" alt="user photo">
                            <div class="card-body" :class="{ 'text-danger ': !user.active }">
                                <h6 class="text-secondary margin-top-small ">Name</h6>
                                <h5><b>{{ user.name }}</b></h5>

                                <h6 class="text-secondary">Email</h6>
                                <a :href="'mailto:' + user.email"><b>{{ user.email }}</b></a>
                                <p  v-if="!user.active"> <i class="fas fa-exclamation-circle fa-fw"></i> User is Disabled</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import {mapGetters} from "vuex";
import Spinner from "../components/Spinner";
import pageHeader from "../components/PageHeader";
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
            inProgress: false,
            loading: false,
            errors: {},
            searchLoading: '',
        }
    },
    methods: {
        /**
         * fetch all users
         */
        fetchAllUsers(context, page = 1) {
            this.loading = true;
            this.$store.dispatch('FETCH_ALL_USERS', page)
                .then(() => this.loading = false)
                .catch(() => {
                    this.loading = false
                    console.log('Fetching Filtered users in users component failed')
                }  );
        },
        /**
         * FetchFilteredUSers
         */
        fetchFilteredUsers(page = 1) {
            this.searchLoading = true;
            this.$store.dispatch('FETCH_FILTERED_USERS', page)
                .then(() => {
                    this.searchLoading = false
                }).catch(() => {
                    this.searchLoading = false
                    console.log('Fetching Filtered users in users component failed')
                }
            );
        },

        /**
         * clear user filters
         */
        clearFilters() {
            this.$store.dispatch('CLEAR_USER_FILTERS');
        },
        /**
         * navigate to Edit
         */
        navigateToEdit(id) {
            this.$router.push({path: `/users-details/${id}` });
        }
    },
    computed: {
        ...mapGetters(["users", "filter"]),
    },
    created() {
        if (this.$gate.isAdmin()) {
            // this.getResults();
            this.fetchAllUsers();
        } else {
            this.$router.push({path: `/dashboard` });
        }
    }
}
</script>
