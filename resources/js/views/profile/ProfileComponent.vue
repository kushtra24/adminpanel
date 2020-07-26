<template>
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <pageHeader title="Profile" />

    <!-- loading spinner-->
    <Spinner v-if="loading" />

    <div class="container" v-if="!loading">
        <div class="row">
            <div class="col-md-2">
                <div class="">
                    <picture>
                        <img :src="profile.photo" alt="Profile photo" class="img-fluid img-thumbnail" width="150px">
                    </picture>
                </div>
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{ profile.name }}</h3>
                    <h5 class="widget-user-desc">{{ profile.type }}</h5>
                </div>
            </div>
        <div class="col-md-5">
            <div class="box box-widget widget-user">
                <div class="card-body">
                    <h6 class="text-secondary margin-top-small ">Name</h6>
                    <h5><b>{{ profile.name }}</b></h5>

                    <h6 class="text-secondary">Email</h6>
                    <a :href="'mailto:' + profile.email"><b>{{ profile.email }}</b></a>\

                    <div class="bio-wrapper" v-if="profile.bio">
                    <h6 class="text-secondary">Bio</h6>
                    <p><b>{{ profile.bio }}</b></p>
                    </div>

                    <h6 class="text-secondary">Type</h6>
                    <p><b>{{ profile.type | upText}}</b></p>

                    <h6 class="text-secondary">Updated</h6>
                    <p><b>{{ profile.updated_at | euDate }}</b></p>

                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="" id="settings">
                <editProfileComponent></editProfileComponent>
            </div>
        </div>
        </div>
    </div>
</div>
</template>

<script>

    import {mapActions, mapGetters} from "vuex";
    import Spinner from "../../components/Spinner";
    import editProfileComponent from "../../components/editProfileComponent";
    import pageHeader from "../../components/PageHeader";

    export default {
        components: {
            Spinner,
            editProfileComponent,
            pageHeader
        },
        beforeCreate() {
            console.log('photo', this.$store.state.profile.photo );
            this.$store.state.profile.photo = '../storage/user/' + this.$store.state.profile.photo;
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
                    .then( () => {
                        this.loading = false
                    })
                    .catch((errors) => {
                        this.loading = false;
                        this.errors = errors.errors;
                        console.log('error profile could not be fetched');
                        Swal.fire(
                            'Failed!',
                            'User was not created',
                            'warning'

                        )
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
