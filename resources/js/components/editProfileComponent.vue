<template>
<div>
    <form @submit.prevent="onSubmitProfile" ref="profileForm">
        <div class="form-group">
            <input placeholder="Name" v-model="profile.name" type="text" name="name" class="form-control">
            <span class="invalid-feedback" v-if="errors.name">{{ errors.name }}</span>
        </div>

        <div class="form-group">
            <input disabled v-bind:class="{ harError: errors.email }" placeholder="Email" v-model="profile.email" type="email" name="email" class="form-control" id="validationCustom03">
            <span class="invalid-feedback" v-if="errors.email">{{ errors.email }}</span>
        </div>

        <div class="form-group">
            <textarea v-model="profile.bio" type="bio" class="form-control" name="bio" aria-label="With textarea" placeholder="Short User bio"></textarea>
        </div>

        <div class="form-group">
            <select name="type" id="type" v-model="profile.type" type="type" class="form-control">
                <option value=""> Select User Role</option>
                <option value="admin">Admin</option>
                <option value="user"> Standard user</option>
                <option value="author">Author</option>
            </select>
        </div>

        <div class="form-group">
            <label for="FormControlProfilePhoto">Add profile Photo</label>
            <input type="file" class="form-control-file" id="FormControlProfilePhoto" @change="updateProfilePhoto">
        </div>

        <button :disabled="inProgress" type="submit" class="btn btn-primary">Submit
            <Spinner v-if="inProgress" class="spinner-mini spinner-color-white" />
        </button>
        <ErrorsList :errors="errors" />
    </form>
</div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ErrorsList from "./ErrorsList";
import Spinner from "./Spinner";

export default {
    name: "editProfileComponent",
    components: {
        ErrorsList,
        Spinner
    },
    data() {
        return {
            loading: false,
            inProgress: false,
            errors: {}
        }
    },
    methods: {
      ...mapActions(['UPDATE_PROFILE', 'UPDATE_PROFILE_PHOTO']),
        /**
         * on submitting the form update authenticated user
         */
        onSubmitProfile() {
            // send request to server to delete user
            this.inProgress = true;
            this.$store.dispatch('UPDATE_PROFILE')
                .then( () => {
                    this.inProgress = false;
                    Swal.fire(
                        'Updated!',
                        'Profile has been Updated.',
                        'success'
                    )
                    // catch an error
                }).catch( ({response}) => {
                    this.inProgress = false;
                    if (response?.data?.errors) {
                        this.errors = response?.data?.errors
                    } else {
                        this.errors = response?.data
                    }
                    Swal.fire(
                        'Failed!',
                        'Nothing was Updated',
                        'warning'
                    )
            });
        },

        /**
         * update profile photo
         * @param event
         */
        updateProfilePhoto(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2111776) {
                reader.onloadend = (file) => {
                    this.$store.dispatch('UPDATE_PROFILE_PHOTO', [reader.result])
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
        ...mapGetters(['profile'])
    },
}
</script>
