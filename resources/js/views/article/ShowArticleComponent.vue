<template>
    <div class="show-article-wrapper">
        <!-- Content Header (Page header) -->
        <pageHeader title="Article Details" :pages="['Dashboard', 'Article']" />

        <div class="container">
            <!-- loading Spinner-->
            <Spinner v-if="loading" />
            <router-link :to="{name: 'editArticles', params: {slug}}" type="a" class="btn btn-warning"><i class="fas fa-edit fa-fw"></i>Edit</router-link>
            <button class="btn btn-danger float-right" @click="deleteArticle"><i class="fas fa-trash-alt fa-fw"></i>Delete</button>
            <hr>
            <div class="row">
                <div class="col-md-2" v-if="article.photo">
                    <img :src="article.photo" alt="article photo" class="img-fluid">
                </div>
                <div class="col-md-10 mt-3">
                    <h3> {{ article.title }}</h3>
                    <h6>{{ article.slug }}</h6>
                    <p>
                        <b>Created at: </b> {{ article.created_at | euDate}},
                        <b>Updated at: </b>{{ article.updated_at | euDate}},
                        <b>Public: </b>{{ article.public | bool}}
                    </p>
                </div>
            </div>
            <div class="article-content mt-4">
                <div v-html="article.content"></div>
            </div>
        </div>
    </div>
</template>

<script>
import pageHeader from "../../components/PageHeader";
import Spinner from "../../components/Spinner";
import {mapGetters} from "vuex";

export default {
    name: "showArticleComponent",
    components: {
        pageHeader,
        Spinner
    },
    data() {
        return {
            slug: this.$route.params.slug,
            loading: false,
        }
    },
    methods: {
        /**
         * fetch article data with slug
         */
        fetchArticleData() {
            this.loading = true;
            this.$store.dispatch('FETCH_ARTICLE_DATA', this.slug)
            .then(() => {
                this.loading = false;
                console.log('article data fetch success');
            })
            .catch(() => {
                this.loading = false;
                console.log('article data fetch error');
            })
        },

        // fetchCategoriesForArticles() {
        //     this.$store.dispatch('FETCH_CATEGORIES_FOR_ARTICLE', this.slug)
        //     .then( () => {
        //         console.log('category data');
        //     })
        //     .cache(() => {
        //         console.log('category error');
        //     })
        // },

        /**
         * Delete an article
         */
        deleteArticle() {
            this.$store.dispatch('DELETE_ARTICLE', this.slug)
            .then(() => {
                console.log('Article deleted');
                this.$router.push({path: '/articles'})
            })
            .catch(() => {
                console.log('Article not deleted');
                this.$router.push({path: '/articles'})
            });
        }
    },
    created() {
        // fetch an article
        this.fetchArticleData();
        // this.fetchCategoriesForArticles();
    },
    computed: {
        ...mapGetters(['article'])
    }
}
</script>
