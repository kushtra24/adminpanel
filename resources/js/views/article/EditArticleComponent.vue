<template>
    <div class="wrapper">
        <!-- Content Header (Page header) -->
        <PageHeader v-if="!id" title="Create Article" :pages="['Dashboard', 'Article']"/>
        <PageHeader v-if="id" title="Edit Article" :pages="['Dashboard', 'Article', 'Article Details']" />

        <div class="container-fluid">
                <form @submit.prevent="onSubmit">
                    <div class="row">
                        <div class="col-md-8 col-md-8 col-lg-8">
                    <div class="form-group">
                        <input type="text" placeholder="Title" v-model="article.title" name="title" class="form-control">
                    </div>
                    <slug :url="fullUrl" sub-directory="blog" :title="article.title"></slug>
                    <div class="form-group">
                        <div class="editor mt-4">
                            <editor-menu-bubble :editor="editor" @hide="hideLinkMenu" :keep-in-bounds="keepInBounds" v-slot="{ commands, getMarkAttrs, isActive, menu }">
                                <div class="menububble" :class="{ 'is-active': menu.isActive }" :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`">
                                    <i class="fas fa-bold" :class="{ 'is-active': isActive.bold() }" @click="commands.bold"></i>
                                    <i class="fas fa-italic" :class="{ 'is-active': isActive.italic() }" @click="commands.italic"></i>
                                    <i class="fas fa-underline" :class="{ 'is-active': isActive.underline() }" @click="commands.underline"></i>
                                    <i class="fas fa-quote-right" :class="{ 'is-active': isActive.blockquote() }" @click="commands.blockquote"></i>
                                    <i class="fas fas fa-list-ol" :class="{ 'is-active': isActive.ordered_list() }" @click="commands.ordered_list"></i>
                                    <i class="fas fa-list-ul" :class="{ 'is-active': isActive.bullet_list() }" @click="commands.bullet_list"></i>
                                    <i class="fas fa-code" :class="{ 'is-active': isActive.code() }" @click="commands.code"></i>
                                    <i class="fas far fa-file-code" :class="{ 'is-active': isActive.code_block() }" @click="commands.code_block"></i>
                                    <i class="fas fa-arrows-alt-h" @click="commands.horizontal_rule"></i>
                                    <i class="fas fa-paragraph" :class="{ 'is-active': isActive.paragraph() }" @click="commands.paragraph"></i>

                                    <span :class="{ 'is-active': isActive.heading({ level: 1 }) }" @click="commands.heading({ level: 1})">h1</span>
                                    <span :class="{ 'is-active': isActive.heading({ level: 2 }) }" @click="commands.heading({ level: 2})">H2</span>
                                    <span :class="{ 'is-active': isActive.heading({ level: 3 }) }" @click="commands.heading({ level: 3})">H3</span>

                                    <form class="menububble__form" v-if="linkMenuIsActive" @submit.prevent="setLinkUrl(commands.link, linkUrl)">
                                        <input class="menububble__input" type="text" v-model="linkUrl" placeholder="https://" ref="linkInput" @keydown.esc="hideLinkMenu"/>
                                        <i class="fas fa-unlink"  @click="setLinkUrl(commands.link, null)"></i>
                                    </form>

                                    <template v-else>
                                        <i class="fas fa-link" @click="showLinkMenu(getMarkAttrs('link'))" :class="{ 'is-active': isActive.link() }"></i>
                                    </template>
                                    <i class="fas far fa-undo" @click="commands.undo"></i>
                                    <i class="fas far fa-redo" @click="commands.redo"></i>
                                </div>
                            </editor-menu-bubble>
                        <editor-content class="editor__content" :editor="editor"/>
                            <div hidden > {{ article.content }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="published-wrapper">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="Published" v-model="article.public">
                            <label class="form-check-label" for="Published">Public</label>
                        </div>
                    </div>
                    <div class="article-photo">
                        <div class="form-group">
                            <picture v-show="article.photo">
                                <img :src="article.photo" alt="article photo" class="img-fluid img-thumbnail" width="150px">
                            </picture>
                            <label for="FormControlUserPhoto">Add Article Photo</label>
                            <input type="file" class="form-control-file" id="FormControlUserPhoto" @change="createArticlePhoto">
                        </div>
                    </div>

                    <div class="category-wrapper">
                        <label>Add category to Article</label>
                        <category categories="article.category"></category>
                    </div>

                    <button :disabled="inProgress" type="submit" class="btn btn-primary mt-3">Submit
                        <Spinner v-if="inProgress" class="spinner-mini spinner-color-white" />
                    </button>
                    <ErrorsList :errors="errors" />
                </div>
            </div>
        </form>
        </div>
    </div>
</template>

<script>
import PageHeader from "../../components/PageHeader";
import {mapActions, mapGetters} from "vuex";
import {Editor, EditorContent, EditorMenuBubble} from 'tiptap';
import Spinner from "../../components/Spinner";
import ErrorsList from "../../components/ErrorsList";
import slug from "../../components/slug"
import category from "../../components/category"

import {Blockquote,
    BulletList,
    CodeBlock,
    Heading,
    ListItem,
    OrderedList,
    Bold,
    Code,
    Italic,
    Link,
    HorizontalRule,
    Underline,
    History,} from 'tiptap-extensions';

export default {
    name: "EditArticleComponent",
    components: {
        PageHeader,
        EditorMenuBubble,
        EditorContent,
        Spinner,
        ErrorsList,
        slug,
        category
    },
    data() {
        return {
            id: this.$route.params.slug,
            fullUrl: window.location.origin,
            inProgress: false,
            errors: {},
            keepInBounds: true,
            newContent: '',
            editor: new Editor({
                // other options omitted for brevity
                extensions: [
                    new Blockquote(),
                    new BulletList(),
                    new CodeBlock(),
                    new Heading({ levels: [1, 2, 3] }),
                    new ListItem(),
                    new OrderedList(),
                    new Link(),
                    new HorizontalRule(),
                    new Bold(),
                    new Code(),
                    new Italic(),
                    new Underline(),
                    new History(),
                ],
                onUpdate: ({ getJSON, getHTML }) => {
                    this.newContent = getHTML();
                },
                content: '<p>This is just a boring paragraph</p>',
            }),
            linkUrl: null,
            linkMenuIsActive: false,
        }
    },
    beforeDestroy() {
        // Always destroy your editor instance when it's no longer needed
        this.editor.destroy()
    },
    methods: {
        ...mapActions(['CREATE_ARTICLE', 'UPDATE_ARTICLE', 'UPDATE_ARTICLE_PHOTO', 'SET_CONTENT_IN_STORE']),

        /**
         * set editor content
         */
        setEditorContent() {
            //set the content to the editor
            this.editor.setContent(this.$store.getters.article.content);
        },

        /**
         * save content
         */
        saveContent() {
            //send to store on save
            this.$store.dispatch('SET_CONTENT_IN_STORE', this.newContent)
            return this.newContent;
        },

        /**
         * create or update the article
         */
        onSubmit() {
            let action = '';
            let actionMessage = '';
            if (this.id) {
                action = 'UPDATE_ARTICLE';
                actionMessage = 'Updated'
            } else {
                action = 'CREATE_ARTICLE';
                actionMessage = 'Created';
            }
            this.inProgress = true;
            this.$store.dispatch(action)
            .then( () => {
                this.inProgress = false;
                Swal.fire(
                    actionMessage,
                    'Article Has been' + actionMessage,
                    'success'
                )
                this.$router.push('/articles');
            })
            .catch(({ response }) => {
                this.inProgress = false;
                if (response?.data?.errors) {
                    this.errors = response?.data?.errors
                } else {
                    this.errors = response?.data
                }
                console.log('you have an error on creating an user');
            })
        },

        /**
         * show link menu
         */
        showLinkMenu(attrs) {
            this.linkUrl = attrs.href
            this.linkMenuIsActive = true
            this.$nextTick(() => {
                this.$refs.linkInput.focus()
            })
        },
        /**
         * hide link menu
         */
        hideLinkMenu() {
            this.linkUrl = null
            this.linkMenuIsActive = false
        },
        /**
         * set link url
         */
        setLinkUrl(command, url) {
            command({ href: url })
            this.hideLinkMenu()
        },

        /**
         * update profile photo
         * @param event
         */
        createArticlePhoto(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2111776) {
                reader.onloadend = (file) => {
                    this.$store.dispatch('UPDATE_ARTICLE_PHOTO', [reader.result])
                }
                reader.readAsDataURL(file);
            } else {
                Swal.fire(
                    'Error!',
                    'oops... file too big, make sure it is less then 2MB',
                    'warning'
                )
            }
        },

        /**
         * reset state if there is not an id in the url
         */
        resetArticleState() {
            // if the id exists in the url parameters get the selected user data

                // reset state of user
                this.$store.dispatch("RESET_ARTICLE_STATE");
        }
    },
    computed: {
        // get user from store
        ...mapGetters(["article", "category"]),
    },
    created() {
        if (this.id) {
          this.setEditorContent();
          // reset state of user
        }
        if(!this.id){
            this.resetArticleState();
        }
    },
    watch: {
        newContent() {
            this.newContent = this.saveContent();
        }
    }
}
</script>
