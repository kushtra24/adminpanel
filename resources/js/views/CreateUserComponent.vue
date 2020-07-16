<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark" v-if="!id">Create User</h1>
            <h1 class="m-0 text-dark" v-if="id">Edit User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
                <li class="breadcrumb-item active"><router-link to="/users">Users</router-link></li>
                <li class="breadcrumb-item active" v-if="id"><router-link :to="{ path: '/users-details/'+ id }">User Details</router-link></li>
                <li class="breadcrumb-item active">User Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="container">
      <form @submit.prevent="onSubmit">
        <div class="form-group">
          <input placeholder="Name" v-model="user.name" type="text" name="name" class="form-control">
            <span class="invalid-feedback" v-if="errors.name">{{ errors.name }}</span>
        </div>

        <div class="form-group">
          <input v-bind:class="{ harError: errors.email }" placeholder="Email" v-model="user.email" type="email" name="email" class="form-control" id="validationCustom03">
            <span class="invalid-feedback" v-if="errors.email">{{ errors.email }}</span>
        </div>

        <div class="form-group">
          <input placeholder="Password" v-model="user.password" type="password" name="password" class="form-control">
            <span class="invalid-feedback" v-if="errors.password">{{ errors.password }}</span>
        </div>

        <div class="form-group">
          <textarea v-model="user.bio" type="bio" class="form-control" name="bio" aria-label="With textarea" placeholder="Short User bio"></textarea>
        </div>

        <div class="form-group">
          <select name="type" id="type" v-model="user.type" type="type" class="form-control">
            <option value=""> Select User Role</option>
            <option value="admin">Admin</option>
            <option value="user"> Standard user</option>
            <option value="author">Author</option>
          </select>
        </div>

          <div class="form-group">
              <label for="FormControlUserPhoto">Add profile Photo</label>
              <input type="file" class="form-control-file" id="FormControlUserPhoto" @change="createUserPhoto">
          </div>

          <div class="form-check" style="margin-bottom: 15px" v-if="id">
              <input type="checkbox" class="form-check-input" id="isActive" name="active" v-model="user.active">
              <label class="form-check-label" for="isActive">Active</label>
          </div>

        <button :disabled="inProgress" type="submit" class="btn btn-primary">Submit
            <Spinner v-if="inProgress" class="spinner-mini spinner-color-white" />
        </button>
          <ErrorsList :errors="errors" />
      </form>
    </div>
</div>
</template>

<script>
import {mapActions, mapGetters, mapState} from "vuex";
import ErrorsList from "../components/ErrorsList";
import Spinner from "../components/Spinner";

export default {
        name: 'createUser',
        components: {
            ErrorsList,
            Spinner
        },
      data() {
        return {
            id: this.$route.params.id,
            inProgress: false,
            errors: {}
        }
      },
      methods: {
          ...mapActions(['UPDATE_USER', 'CREATE_USER', 'FETCH_SELECTED_USER', 'RESET_STATE', 'UPDATE_USER_PHOTO']),

          /**
           * on submitting the form update or crete a user
           */
          onSubmit() {
              let action = '';
              let actionMessage = '';

              if (this.id) {
                  action = 'UPDATE_USER';
                  actionMessage = 'Updated';
              } else {
                  action = 'CREATE_USER';
                  actionMessage = 'Created';
              }
              // let action = this.id ? 'UPDATE_USER' : 'CREATE_USER';
              // let actionMessage = this.id ? 'Updated' : 'Created';
              this.inProgress = true;
              this.$store
                  .dispatch(action)
                  .then(() => {
                      this.inProgress = false;
                      Swal.fire(
                                actionMessage,
                          'User has been ' + actionMessage,
                          'success'
                      );
                      // navigate to user
                      this.$router.push('/users');
                  })
                  .catch( ({ response }) => {
                      this.inProgress = false;
                      this.errors = response?.data?.errors;
                      console.log('you have an error on creating an user');
                      Swal.fire(
                          'Failed!',
                          'Nothing was Updated',
                          'warning'
                      )
                    });
            },

          /**
           * reset state if there is not an id in the url
           */
          resetState() {
               // if the id exists in the url parameters get the selected user data
              if(!this.id){
                  // reset state of user
                  this.$store.dispatch("RESET_STATE");
              }
          },

          /**
           * update profile photo
           * @param event
           */
          createUserPhoto(event) {
              let file = event.target.files[0];
              let reader = new FileReader();
              console.log('file => ', file);
              if (file['size'] < 2111776) {
                  reader.onloadend = (file) => {
                      this.$store.dispatch('UPDATE_USER_PHOTO', [reader.result])
                  }
                  reader.readAsDataURL(file);
              } else {
                  Swal.fire(
                      'Error!',
                      'oops... file too big, make sure it is less then 2MB',
                      'warning'
                  )
              }
          }

      },
    computed: {
        // get user from store
        ...mapGetters(["user"])
    },
    created() {
           this.resetState()
    }
}
</script>
