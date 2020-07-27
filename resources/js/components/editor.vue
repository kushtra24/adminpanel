<template>
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
</template>

<script>

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
import {Editor, EditorContent, EditorMenuBubble} from "tiptap";

export default {
    name: "LoadingSpinner",
    components: {
        EditorMenuBubble,
        EditorContent,
    },
    data() {
        return {
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
                content: '<p>This is just a boring paragraph</p>',
            }),
            linkUrl: null,
            linkMenuIsActive: false,
        }
    },
    methods: {
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
    }
};
</script>
