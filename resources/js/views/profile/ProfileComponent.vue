<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/dashboard">Dashboard</router-link></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- loading spinner-->
    <Spinner v-if="loading" />

    <div class="container" v-if="!loading">
        <div class="row">
        <div class="col-md-6">
            <div class="box box-widget widget-user">
                <div class="" style="text-align: center">
                    <picture>
                        <img :src="profile.photo" alt="Profile photo" class="img-fluid img-thumbnail" width="150px">
                    </picture>
                </div>
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{ profile.name }}</h3>
                    <h5 class="widget-user-desc">{{ profile.type }}</h5>
                </div>

                <div class="card-body">
                    <h6 class="text-secondary margin-top-small ">Name</h6>
                    <h5><b>{{ profile.name }}</b></h5>

                    <h6 class="text-secondary">Email</h6>
                    <a :href="'mailto:' + profile.email"><b>{{ profile.email }}</b></a>

                    <h6 class="text-secondary">Bio</h6>
                    <p><b>{{ profile.bio }}</b></p>

                    <h6 class="text-secondary">Type</h6>
                    <p><b>{{ profile.type | upText}}</b></p>

                    <h6 class="text-secondary">Updated</h6>
                    <p><b>{{ profile.updated_at | euDate }}</b></p>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="" id="settings">
                <EditProfileComponent></EditProfileComponent>
            </div>
        </div>
        </div>
    </div>
</div>
</template>

<script>

import {mapActions, mapGetters} from "vuex";
    import Spinner from "../../components/Spinner";
    import EditProfileComponent from "../../components/editProfileComponent";

    export default {
        components: {
            Spinner,
            EditProfileComponent
        },
        beforeCreate() {
            console.log('photo', this.$store.state.profile.photo );
            this.$store.state.profile.photo = '../storage/' + this.$store.state.profile.photo;
        },
        data() {
          return {
              loading: false,
              errors: {}
          }
        },
        methods: {
            ...mapActions(['FETCH_PROFILE']),
            /**
             * fetch profile
             */
            fetchProfile() {
                this.loading = true;
                this.$store.dispatch('FETCH_PROFILE')
                    .then( () => this.loading = false)
                    .catch((errors) => {
                        this.loading = false;
                        this.errors = errors.errors;
                        console.log('error profile could not be fetched');
                    })
            }
        },
        computed: {
          ...mapGetters(['profile']),
        },
        created() {
            this.fetchProfile();
        }
    }
</script>
