<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="container">

      <form @submit.prevent="createUser">
        <div class="form-group">
          <input placeholder="Name" v-model="form.name" type="text" name="name"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
          <input placeholder="Email" v-model="form.email" type="email" name="email"
            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
          <has-error :form="form" field="email"></has-error>
        </div>

        <div class="form-group">
          <input placeholder="Password" v-model="form.password" type="password" name="password"
            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
          <has-error :form="form" field="password"></has-error>
        </div>

        <div class="form-group">
          <textarea v-model="form.bio" type="bio" class="form-control" name="bio" aria-label="With textarea"
          :class="{ 'is-invalid': form.errors.has('bio') }" placeholder="Short User bio"></textarea>
          <has-error :form="form" field="bio"></has-error>
        </div>

        <div class="form-group">
          <select name="type" id="type" v-model="form.type" type="type" class="form-control" :class="{ 'is-valid': form.errors.has('type') }">
            <option value=""> Select User Role</option>
            <option value="admin">Admin</option>
            <option value="user"> Standard user</option>
            <option value="author">Author</option>
          </select>
          <has-error :form="form" field="type"></has-error>
        </div>

        <button :disabled="form.busy" type="submit" class="btn btn-primary">Log In</button>
      </form>
    </div>
</div>
</template>

<script>

    export default {
      data() {
        return {
          form: new Form({
            name: '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: ''
          })
        }
      },
      methods: {
        createUser() {
          this.form.post('api/user')
          .then(({data}) => { console.log(data)})
        }
      },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
