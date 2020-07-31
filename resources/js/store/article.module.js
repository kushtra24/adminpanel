
function initialArticleState() {
    return {
        article: {
            title: '',
            slug: '',
            content: '',
            photo: '',
            public: true,
            // category: [],
            created_at: '',
            updated_at: '',
            cat: []
        },
    }
}

export  default {
    state: {
        ...initialArticleState(),
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
                return this.state.article;
            } else {
                let url = '/api/article?page=' + page;
                const article = await axios.get(url);
                context.commit('SET_ALL_ARTICLES', article.data);
            }
        },

        /**
         * fetch filtered article
         * @param context
         * @param page
         */
        async FETCH_FILTERED_ARTICLES(context, page) {
            let url = '/api/article?page=' + page;
            const article = await axios.get(url);
            context.commit('SET_ALL_ARTICLES', article.data);
        },

        /**
         * get article detaild data
         * @param context
         * @param slug
         * @returns {Promise<void>}
         * @constructor
         */
        async FETCH_ARTICLE_DATA(context, slug) {
          let url = '/api/article/';
          const article = await axios.get(url + slug);
          context.commit('SET_ARTICLE_DATA', article.data);
        },

        /**
         * create article
         * @param state
         * @returns {Promise<void>}
         * @constructor
         */
        async CREATE_ARTICLE({state}) {
            await axios.post('/api/article', state.article);
            state.articleStateChanged = true;
        },

        async DELETE_ARTICLE(context, slug) {
            await axios.delete("/api/article/" + slug);
        },

        /**
         * Set content in store
         * @param state
         * @param content
         */
        SET_CONTENT_IN_STORE({state}, content) {
            state.article.content = content;
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

        /**
         * update slug
         * @param context
         * @param slug
         * @constructor
         */
        UPDATE_SLUG(context, slug) {
            context.commit('SET_SLUG', slug)
        },

        /**
         * reset state
         */
        RESET_ARTICLE_STATE({commit}) {
            commit('ARTICLE_RESET_STATE');
        },

    },
    mutations: {

        /**
         * mutate articles state
         * @param state
         * @param articles
         * @constructor
         */
        SET_ALL_ARTICLES: (state, articles) => {
                state.articles = articles;
                state.articleStateChanged = false;
        },

        /**
         * set article data
         * @param state
         * @param article
         * @constructor
         */
        SET_ARTICLE_DATA: (state, article) => {
          state.article = article;
          state.article.photo = '../storage/article/' + state.article.photo;
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

        /**
         * set slug
         * @param state
         * @param slug
         * @constructor
         */
        SET_SLUG: (state, slug) => {
            state.article.slug = slug;
        },

        /**
         * reset user state
         * @param state
         * @constructor
         */
        ARTICLE_RESET_STATE: (state) => {
            Object.assign(state, initialArticleState())
        },

    },
    getters: {
        articles: (state) => {
            return state.articles;
        },
        article: (state) => {
            return state.article;
        },
    }
};
