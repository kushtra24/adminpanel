
function initialState () {
    return {
        profile: {
            name: '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: '',
            active: '1',
            updated_at: ''
        },
    }
}

export default {
    state: {
        ...initialState(),
        UserStateChanged: false,
    },
    actions: {

        /**
         * fetch authenticated user
         * @param state
         * @returns {Promise<void>}
         * @constructor
         */
        async FETCH_PROFILE(context) {
            const profile  = await axios.get("/api/profile/");
            context.commit('SET_PROFILE', profile.data);
        },

        /**
         * update authenticated user
         * @returns {Promise<void>}
         * @constructor
         */
        async UPDATE_PROFILE({state}) {
            await axios.put('/api/profile/', state.profile);
            this.state.UserStateChanged = true;
        },

        /**
         * update photo state
         * @param state
         * @constructor
         */
        UPDATE_PROFILE_PHOTO(context, [reader]) {
            console.log('profile photo',);
            context.commit('SET_PROFILE_PHOTO', reader);
        },

        /**
         * reset state
         */
        RESET_STATE({commit}) {
            commit('RESET_STATE');
        },

    },
    mutations: {
        SET_PROFILE: (state, profile) => {
        state.profile = profile,
        state.profile.photo = '../storage/user/' + state.profile.photo
        },
        SET_PROFILE_PHOTO: (state, reader) => {
            state.profile.photo = reader;
        }
    },
    getters: {
        profile(state) {
            return state.profile;
        },
    }
};
