<template>
<div class="wrapper">
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

            <div class="users-cards" v-if="!loading">
                <div class="card" style="width: 18rem;" v-for="user in users" :key="user.id" @click="navigateToEdit(user.id)" v-bind:class="{ 'border-danger ': !user.active }">
                    <img v-if="user.photo" v-bind:src="user.photo" class="card-img-top" alt="Card image cap">
                    <img v-if="!user.photo" v-bind:src="'./img/profile.png'" class="card-img-top" alt="no image">
                    <div class="card-body" v-bind:class="{ 'text-danger ': !user.active }">
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
</template>

<script>

    import {mapState} from "vuex";
    import Spinner from "../components/Spinner";

    export default {
        components: {
            Spinner,
        },
        computed: {
            ...mapState([
                'users',
                'loading'
            ])
        },
        methods: {
            /**
             * fetch all users
             */
            fetchAllUsers() {
                this.$store.dispatch('FETCH_ALL_USERS');
            },
            /**
             * navigate to Edit
             */
            navigateToEdit(id) {
                this.$router.push({path: `/users-details/${id}` });
            }
        },
        created() {
            this.fetchAllUsers();
        }
    }
</script>
