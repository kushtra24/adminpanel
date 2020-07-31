<template>
    <div class="wrapper">
        <!-- Content Header (Page header) -->
        <PageHeader title="User Details" :pages="['Dashboard', 'Users']" />

        <div class="container">
            <!-- loading spinner-->
            <Spinner v-if="loading" />

            <div class="info-container" v-if="!loading">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-tie fa-fw"></i>
                        <b>User Information</b> <span class="float-right"> user ID: {{user.id}}</span>
                    </div>
                    <div class="card-body">
                        <picture>
                            <img v-if="!user.photo" :src="'/../img/profile.png'" class="card-img-top" alt="no image">
                            <img v-if="user.photo" :src="'/../storage/user/' + user.photo" class="card-img-top" alt="user photo">
                        </picture>
                        <h6 class="text-secondary margin-top-small ">Name</h6>
                        <h5><b>{{ user.name }}</b></h5>

                        <h6 class="text-secondary">Email</h6>
                        <a :href="'mailto:' + user.email"><b>{{ user.email }}</b></a>

                        <h6 class="text-secondary">Bio</h6>
                        <p><b>{{ user.bio | upText}}</b></p>

                        <h6 class="text-secondary">Type</h6>
                        <p><b>{{ user.type | upText }}</b></p>

                        <h6 class="text-secondary">Created at</h6>
                        <p><b>{{ user.created_at | euDate }}</b></p>

                        <a href="#" @click="navigateToEdit" class="btn btn-info"><i class="fas fa-user-edit fa-fw"></i> Edit User</a>
                        <a href="#" @click="deleteUser(user.id)" class="btn btn-danger float-right"><i class="fas fa-user-slash fa-fw "></i> Delete User</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Spinner from "../components/Spinner";
import {mapActions, mapGetters} from "vuex";
import PageHeader from "../components/PageHeader";
export default {
    components: {
        Spinner,
        PageHeader
    },
    data() {
        return {
            id: this.$route.params.id,
            loading: false,
        }
    },
    methods: {
        ...mapActions(['FETCH_SELECTED_USER', 'DELETE_USER']),
        /**
         *  fetch selected user
         */
        fetchSelectedUser() {
            if (this.id){
                this.loading = true;
                this.$store.dispatch("FETCH_SELECTED_USER", this.id)
                    .then(() => this.loading = false
                    ).catch( () => console.log('can\'t get the user data with this id'));
            }
        },
        /**
         * delete the selected user
         * @param id user
         */
        deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // if user clicked on yes delete it then proceed
                if (result.value) {
                    // send request to server to delete user
                    this.$store.dispatch('DELETE_USER')
                        .then( () => {
                            Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            )
                            this.$router.push('/users');
                            // catch an error
                        }).catch( () => {
                        Swal.fire(
                            'Failed!',
                            'Nothing was deleted',
                            'warning'
                        )
                    });
                }
            })
        },
        /**
         * navigate to edit page
         * @param id
         */
        navigateToEdit() {
            this.$router.push({path: `/users-edit/${this.id}` });
        },
    },
    computed: {
        ...mapGetters(["user"])
    },
    created() {
        this.fetchSelectedUser();
    }
}
</script>
