
function initialState() {
    return {
        article: {
            title: '',
            slug: '',
            content: '',
            public: '',
            created_at: '',
            updated_at: ''
        },
    }
}

export  default {
    state: {
        ...initialState(),
        articleStateChanged: false,
        articles: {}
    },
    actions: {

        /**
         * get all articles
         * @param context
         * @param page
         * @returns {Promise<{public: string, updated_at: string, created_at: string, title: string, slug: string, content: string}|{mutations: {}, state: {articleStateChanged: boolean, articles: {}, article: {public: string, updated_at: string, created_at: string, title: string, slug: string, content: string}}, getters: {}, actions: {FETCH_ALL_ARTICLES(*, *): Promise<default.actions.state.article|undefined>}}>}
         * @constructor
         */
        async FETCH_ALL_ARTICLES(context, page) {

            if (!context.state.articleStateChanged && Object.keys(context.state.articles).length !== 0 ) {
                this.state.articleStateChanged = false;
                return this.state.article;
            } else {
              let url = '/api/article?page=' + page;
              const article = await axios.get(url);
              context.commit('SET_ALL_ARTICLES', article.data);
            }
        }
    },
    mutations: {

        /**
         * mutate articles state
         * @param state
         * @param article
         * @constructor
         */
        SET_ALL_ARTICLES: (state, article) => {
                state.articles = article;
                state.articleStateChanged = false;
        },


    },
    getters: {
        articles: (state) => {
            return state.articles;
        }
    }
};
