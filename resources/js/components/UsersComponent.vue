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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <div class="container-fluid">

        <div class="box margin-top-medium">
            <div class="box-header">

              <div class="box-tools">

              </div>
            </div>
            <!-- /.box-header -->

            <!-- loading spinner-->
            <div v-if="loading" class="lds-ring spinner-color-black spinner-center"><div></div><div></div><div></div><div></div></div>

            <!-- user table-->
            <div class="box-body table-responsive no-padding" v-if="!loading">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Create at</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="user in users" :key="user.id" @click="navigateToEdit(user.id)">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type | upText }}</td>
                  <td>{{ user.created_at | euDate }}</td>
                  <td>
                    <a href="#">Edit <i class="fa fa-edit"></i></a>
                    <a href="#" @click="deleteUser(user.id)">Trash <i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
    </div>


</div>
</template>

<script>

    export default {
        data() {
            return {
                users : {},
                loading: false,
            }
        },
        methods: {
            /**
             * get all user from database
             */
            getAllUsers() {
                this.loading = true
                axios.get("api/user").then(
                    ({data}) => {
                        this.users = data
                        this.loading = false
                    }
                ).catch( () => console.log('can\'t get the user data'));
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
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // if user clicked on yes delete it then proceed
                    if (result.value) {
                        // send request to server to delete user
                        axios.delete('api/user/' + id)
                        .then( () => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
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

            // navigate to edit page
            navigateToEdit(id) {
                console.log('id -> ', id);
                this.$router.push({path: `/users-edit/${id}` });
            }

        },
        created() {
            this.getAllUsers();
        }
    }
</script>
