<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
              <li class="breadcrumb-item active"><router-link to="/users">Users</router-link></li>
              <li class="breadcrumb-item active">User Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

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
                        <img v-bind:src="user.photo" alt="user photo" class="img-fluid img-thumbnail" width="150px">
                    </picture>
                    <h6 class="text-secondary margin-top-small ">Name</h6>
                    <h5><b>{{ user.name }}</b></h5>

                    <h6 class="text-secondary">Email</h6>
                    <a :href="'mailto:' + user.email"><b>{{ user.email }}</b></a>

                    <h6 class="text-secondary">Bio</h6>
                    <p><b>{{ user.bio }}</b></p>

                    <h6 class="text-secondary">Type</h6>
                    <p><b>{{ user.type }}</b></p>

                    <h6 class="text-secondary">Created at</h6>
                    <p><b>{{ user.created_at }}</b></p>

                    <a href="#" @click="navigateToEdit(user.id)" class="btn btn-info"><i class="fas fa-user-edit fa-fw"></i> Edit User</a>
                    <a href="#" @click="deleteUser(user.id)" class="btn btn-danger float-right"><i class="fas fa-user-slash fa-fw "></i> Delete User</a>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>

    import Spinner from "../components/Spinner";
    import {mapActions, mapGetters, mapState} from "vuex";

    export default {
        components: {
          Spinner
        },
      data() {
        return {
            id: this.$route.params.id,
            loading: false,
        }
      },
        computed: {
            ...mapGetters(["user"])
        },
      methods: {
            ...mapActions(['FETCH_SELECTED_USER', 'DELETE_USER']),

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
          navigateToEdit(id) {
              console.log('id -> ', id);
              this.$router.push({path: `/users-edit/${id}` });
          },
    },
        created() {
            if (this.id){
                this.loading = true;
                this.$store.dispatch("FETCH_SELECTED_USER", this.id)
                    .then(() => {
                            this.loading = false;
                        }
                    ).catch( () => console.log('can\'t get the user data with this id'));
            }
        }
    }
</script>
