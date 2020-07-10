import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

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

export const store = new Vuex.Store({
    namespaced: true,
    state: { ...initialState(),
        users: [],
        newUserCreated: false,
    },
    actions: {
        /**
         * get all users from database
         */
        async FETCH_ALL_USERS(context) {
            // check if new user is created and users property has data
            // avoid extronuous network call if article exists
            if (this.state.newUserCreated === false && this.state.users.length > 0) {
                this.state.newUserCreated = false;
                return this.state.users;
            } else {
                const user  = await axios.get("api/user/");
                context.commit('SET_ALL_USERS', user.data);
            }
        },

        /**
         * update or create the user
         */
        async CREATE_USER({state}) {
            await axios.post('api/user', state.user);
            this.state.newUserCreated = true;
            console.log('new user? 2 ->', this.state.newUserCreated);
        },

        /**
         * create a new user
         */
       async UPDATE_USER({state}) {
            await axios.put("/api/user/" + state.user.id, state.user);
        },

        /**
         *
         * @param context
         * @param id
         * @returns {Promise<any>}
         * @constructor
         */
        async FETCH_SELECTED_USER(context, id) {
            console.log('here -> ', id);
            const user  = await axios.get("/api/user/" + id);
            context.commit('SET_SELECTED_USER', user.data);
        },

        /**
         *
         * @param context
         * @constructor
         */
        FETCH_EXISTING_USER_DATA(context) {
            console.log('fetch existing user data');
            context.commit('SET_EXISTING_USER');
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
            state.newUserCreated = false;
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
        SET_CREATED_USER: (state) => {
            state.newUserCreated = true;
        },

        /**
         * return existing user
         * @param state
         * @returns {*}
         * @constructor
         */
        SET_EXISTING_USER: (state) => {
            console.log('user? => ', state.user);
            return state.user
        }

    },
    getters: {
        user(state) {
            return state.user;
        }
    }

})
