<template>
<div class="wrapper" v-if="$gate.isAdmin()">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark inline-block">Users</h1>
            <router-link to="/users-create" type="a" class="btn btn-success margin-small"> Create User</router-link>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <div class="container-fluid">

        <div class="box margin-top-medium">

            <!-- loading spinner-->
            <Spinner v-if="loading" />

            <div id="users-container" v-if="!loading">
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


                <Spinner v-if="searchLoading" class=" spinner-color-black" />
                <pagination :data="users" @pagination-change-page="fetchAllUsers">
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

    export default {
        components: {
            Spinner,
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
            fetchAllUsers(page = 1) {
                this.loading = true;
                this.$store.dispatch('FETCH_ALL_USERS', page)
                    .then(() => this.loading = false)
                    .catch(() => {
                        this.loading = false
                        console.log('Fetching Filtered users in users component failed')
                    }  );
            },

            fetchFilteredUsers() {
                this.searchLoading = true;
                this.$store.dispatch('FETCH_FILTERED_USERS')
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

            /**
             * fetch searched users
             */
            // searchUser(event) {
            //     clearTimeout(this.debounce)
            //     this.debounce = setTimeout(() => {
            //         console.log('searched -> ', event.target.value);
            //         this.searchLoading = true;
            //         this.$store.dispatch('SEARCH_USER', event.target.value)
            //             .then(() => this.searchLoading = false)
            //             .catch(() => console.log('error on Searching'));
            //     }, 600)
            // },
            //
            // filterUser(event) {
            //     this.searchLoading = true;
            //     this.$store.dispatch('SEARCH_USER',event.target.value)
            //     .then( () => this.searchLoading = false)
            //     .catch(() => console.log('Error in Filtering the user types'))
            // },

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
