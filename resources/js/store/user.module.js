
function initialState () {
    return {
        user: {
            name: '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: '',
            active: '1',
        },
    }
}

export default {
    state: {
        ...initialState(),
        users: {},
        UserStateChanged: false,
    },
    actions: {
        /**
         * get all users from database
         * @param context
         * @returns {Promise<[]|(function(*): [])|[number, number, [], string, string]|(function(*): [])>}
         * @constructor
         */
        async FETCH_ALL_USERS(context, page) {
            // check if new user is created and users property has data
            // avoid extraneous network call if article exists
            if (this.state.UserStateChanged === false && this.state.users.length > 0) {
                this.state.UserStateChanged = false;
                return this.state.users;
            } else {
                const user  = await axios.get("/api/user?page=" + page);
                console.log('all users -> ', user.data);
                context.commit('SET_ALL_USERS', user.data);
            }
        },

        /**
         * update or create the user
         */
        async CREATE_USER({state}, page = 1) {
            await axios.post('/api/user?page=' + page, state.user);
            this.state.UserStateChanged = true;
            // commit('USER_CHANGED');
        },

        /**
         * create a new user
         */
        async UPDATE_USER({state}) {
            await axios.put("/api/user/" + state.user.id, state.user);
            this.state.UserStateChanged = true;
            // commit('USER_CHANGED');
        },


        /**
         * update photo state
         * @param state
         * @constructor
         */
        UPDATE_USER_PHOTO(context, [reader]) {
            context.commit('SET_USER_PHOTO', reader);
        },

        /**
         * create a new user
         */
        async DELETE_USER({state}) {
            await axios.delete("/api/user/" + state.user.id);
            this.state.UserStateChanged = true;
            // commit('USER_CHANGED');
        },

        /**
         *
         * @param context
         * @param id
         * @returns {Promise<any>}
         * @constructor
         */
        async FETCH_SELECTED_USER(context, id) {
            const user  = await axios.get("/api/user/" + id);
            context.commit('SET_SELECTED_USER', user.data);
        },


        /**
         * reset state
         */
        RESET_STATE({commit}) {
            commit('RESET_STATE');
        },

    },
    mutations: {
        /**
         * set all users
         * @param state
         * @param users
         * @constructor
         */
        SET_ALL_USERS: (state, users) => {
            state.users = users;
            state.UserStateChanged = false;
        },

        /**
         * set selected user
         * @param state
         * @param user
         * @constructor
         */
        SET_SELECTED_USER: (state, user) => {
            state.user = user;
        },

        SET_USER_PHOTO: (state, reader) => {
            state.user.photo = reader
        },

        /**
         * reset user state
         * @param state
         * @constructor
         */
        RESET_STATE: (state) => {
            Object.assign(state, initialState())
        },

        /**
         * set created user
         * @param state
         * @constructor
         */
        USER_CHANGED: (state) => {
            state.UserStateChanged = true;
            console.log('new user? delete ->', this.state.UserStateChanged);
        },



    },
    getters: {
        user(state) {
            return state.user;
        },
        users(state) {
            return state.users;
        }
    }
};
