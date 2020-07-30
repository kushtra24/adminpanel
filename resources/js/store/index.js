import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import user from "./user.module";
import profile from "./profile.module";
import article from "./article.module";
import category from "./category.module"

export default new Vuex.Store({
    modules: {
        user,
        profile,
        article,
        category,
    }
});
