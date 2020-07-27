
function initialState() {
    return {
        article: {
            title: '',
            slug: '',
            content: '',
            photo: '',
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
        },
        /**
         * update photo state
         * @param state
         * @constructor
         * @param context
         */
        UPDATE_ARTICLE_PHOTO(context, [reader]) {
            context.commit('SET_ARTICLE_PHOTO', reader);
        },


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

        /**
         * set user photo
         * @param state
         * @param reader
         * @constructor
         */
        SET_ARTICLE_PHOTO: (state, reader) => {
            state.article.photo = reader
        },

    },
    getters: {
        articles: (state) => {
            return state.articles;
        },
        article: (state) => {
            return state.article;
        }
    }
};
