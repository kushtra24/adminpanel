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
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Create at</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type | upText }}</td>
                  <td> {{ user.created_at | euDate }}</td>
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
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    created_at: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            /**
             * get all user from database
             */
            getAllUsers() {
                axios.get("api/user").then(
                    ({data}) => (this.users = data));
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
                    // send request to server
                    axios.delete('api/user/' + id).then( () => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    ).catch( () => {
                        Swal.fire(
                            'Failed!',
                            'Nothing was deleted',
                            'warning'
                        )
                    });
                })
            },

            
        },
        created() {
            this.getAllUsers();
        }
    }
</script>
