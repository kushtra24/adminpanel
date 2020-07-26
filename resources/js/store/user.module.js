
function initialState() {
    return {
        user: {
            name: '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: '',
            active: '1',
            created_at: ''
        },
    }
}

function initialUserFilters() {
    return {
        filter: {
            search: '',
            type: '',
        }
    }
}

export default {
    state: {
        ...initialState(),
        users: {},
        userStateChanged: false,
        ...initialUserFilters()
    },
    actions: {
        /**
         * get all users from database
         * @param context
         * @param page
         * @returns {Promise<[]|(function(*): [])|[number, number, [], string, string]|(function(*): [])>}
         * @constructor
         */
        async FETCH_ALL_USERS(context, page) {
            // check if new user is created and users property has data
            // avoid extraneous network call if article exists

            if (context.state.userStateChanged === false && Object.keys(context.state.users).length !== 0 ) {
                this.state.userStateChanged = false;
                return this.state.users;
            } else {
                 let url = '/api/user?page=' + page;
                const user  = await axios.get(url);
                context.commit('SET_ALL_USERS', user.data);
            }
        },

        /**
         * get all users from database
         * @param context
         * @param page
         * @returns {Promise<[]|(function(*): [])|[number, number, [], string, string]|(function(*): [])>}
         * @constructor
         */
        async FETCH_FILTERED_USERS(context, page) {
            console.log('page => ', page);
                let url = '/api/user?';

                if (page > 0) {
                    url += "page=" + page;
                }else {
                    url += "page=1"
                }

                if (context.state.filter.search) {
                    url += "&search=" + context.state.filter.search;
                }{
                if (context.state.filter.type)
                    url += "&type=" + context.state.filter.type;
                }

                const user  = await axios.get(url);
                context.commit('SET_ALL_USERS', user.data);
        },

        CLEAR_USER_FILTERS(context) {
            context.commit('RESET_USER_FILTERS');
        },

        /**
         * get all searched users
         * @param context
         * @param searchTerm
         * @param filterType
         * @returns {Promise<void>}
         * @constructor
         */
        SEARCH_USER: (context, searchTerm = '', filterType = '') => {
            const user = axios.get('/api/user?search=' + searchTerm + '&type=' + filterType);
            context.commit('SET_SEARCHED_USER', user.data);
        },

        /**
         * filter users based on type
         * @param context
         * @param filteredUser
         * @returns {Promise<void>}
         * @constructor
         */
        async FILTER_TYPE(context, filteredUser) {
            const user = await axios.get('api/user?type=' + filteredUser);
            context.commit('SET_FILTERED_USER_TYPE', user.data)
        },

        /**
         * update or create the user
         */
        async CREATE_USER({state}) {
            await axios.post('/api/user', state.user);
            state.userStateChanged = true;
            // commit('USER_CHANGED');
        },

        /**
         * create a new user
         */
        async UPDATE_USER({state}) {
            await axios.put("/api/user/" + state.user.id, state.user);
            state.userStateChanged = true;
            // commit('USER_CHANGED');
        },


        /**
         * update photo state
         * @param state
         * @constructor
         * @param context
         */
        UPDATE_USER_PHOTO(context, [reader]) {
            context.commit('SET_USER_PHOTO', reader);
        },

        /**
         * create a new user
         */
        async DELETE_USER({state}) {
            await axios.delete("/api/user/" + state.user.id);
            this.state.userStateChanged = true;
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
            state.userStateChanged = false;
        },

        /**
         * set searched users
         * @param state
         * @param searchedUser
         * @constructor
         */
        SET_SEARCHED_USER(state, searchedUser) {
            state.users = searchedUser;
        },

        /**
         * set user type
         * @param state
         * @param filteredUserType
         * @constructor
         */
        SET_FILTERED_USER_TYPE(state, filteredUserType) {
            state.users = filteredUserType;
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
         * set user photo
         * @param state
         * @param reader
         * @constructor
         */
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
         * Reset user filters
         * @param state
         * @constructor
         */
        RESET_USER_FILTERS: (state) => {
          Object.assign(state, initialUserFilters());
          console.log('new user filter ->', state.filter);
        },

        /**
         * set created user
         * @param state
         * @constructor
         */
        USER_CHANGED: (state) => {
            state.userStateChanged = true;
        },

    },
    getters: {
        user: (state) => {
            return state.user;
        },
        users: (state) => {
            return state.users;
        },
        filter: (state) => {
            return state.filter
        }

        // search: (state) => {
        //     return state.search
        // },
        // type: (state) => {
        //  return state.type;
        // }
    }
};
