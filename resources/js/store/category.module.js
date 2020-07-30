
function initialState () {
    return {
        category: {
            name: '',
            slug: '',
        },
    }
}

export default {
    state: {
        ...initialState(),
        categories: {}
        // categoryStateChanged: false,
    },
    actions: {

        /**
         * fetch authenticated user
         * @param state
         * @returns {Promise<void>}
         * @constructor
         */
        async FETCH_CATEGORIES(context) {
            const categories  = await axios.get("/api/category");
            context.commit('SET_CATEGORY', categories.data);
        },

        // /**
        //  * reset state
        //  */
        // RESET_STATE({commit}) {
        //     commit('RESET_STATE');
        // },

    },
    mutations: {
        SET_CATEGORY: (state, categories) => {

        state.categories = categories
        }
    },
    getters: {
        categories(state) {
            return state.categories;
        },
    }
};
