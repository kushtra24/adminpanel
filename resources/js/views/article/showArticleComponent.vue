<template>
    <div class="show-article-wrapper">
        <!-- Content Header (Page header) -->
        <pageHeader title="Article Details" :pages="['Dashboard', 'Article']" />

        <div class="container">
            <!-- loading spinner-->
            <spinner v-if="loading" />
            <p>{{ article.title }}</p>
            <p>{{ article.slug }}</p>
            <p>{{ article.created_at | euDate}}</p>
            <p>{{ article.updated_at | euDate}}</p>
            <p>{{ article.public | bool}}</p>

            <div class="article-content">
                <div v-html="article.content"></div>
            </div>
        </div>
    </div>
</template>

<script>
import pageHeader from "../../components/PageHeader";
import spinner from "../../components/Spinner";
import {mapGetters} from "vuex";

export default {
    name: "showArticleComponent",
    components: {
        pageHeader,
        spinner
    },
    data() {
        return {
            slug: this.$route.params.slug,
            loading: false,
        }
    },
    methods: {
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
        }
    },
    created() {
        this.fetchArticleData();
    },
    computed: {
        ...mapGetters(['article'])
    }
}
</script>
