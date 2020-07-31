
function initialCategoryState () {
    return {
        category: {
            name: '',
            slug: '',
        },
    }
}

export default {
    state: {
        ...initialCategoryState(),
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

        /**
         * reset state
         */
        RESET_CATEGORIES_STATE({commit}) {
            commit('RESET_CATEGORIES');
        },

    },
    mutations: {
        /**
         * set category data
         * @param state
         * @param categories
         * @constructor
         */
        SET_CATEGORY: (state, categories) => {
        state.categories = categories
        },

        /**
         * reset Categories
         * @constructor
         */
        RESET_CATEGORIES: (state) => {
            Object.assign(state, initialCategoryState())
        }
    },
    getters: {
        categories(state) {
            return state.categories;
        },

        category(state) {
            return state.category;
        }
    }
};
