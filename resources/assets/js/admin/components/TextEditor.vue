<template>
<div class="a-text-editor">
    <div class="a-text-editor__container editor">
        <editor-menu-bar
            :editor="editor"
            v-slot="{ commands, isActive }"
        >
            <div class="menubar">
                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.bold() }"
                    @click="commands.bold"
                >
                    B
                </button>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.italic() }"
                    @click="commands.italic"
                >
                    I
                </button>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.strike() }"
                    @click="commands.strike"
                >
                    S
                </button>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.underline() }"
                    @click="commands.underline"
                >
                    U
                </button>

                <div class="menubar__spacer"></div>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.bullet_list() }"
                    @click="commands.bullet_list"
                >
                    Lista
                </button>

                <div class="menubar__spacer"></div>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.heading({ level: 1 }) }"
                    @click="commands.heading({ level: 1 })"
                >
                    H1
                </button>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 })"
                >
                    H2
                </button>

                <button
                    class="menubar__button"
                    :class="{ 'is-active': isActive.heading({ level: 3 }) }"
                    @click="commands.heading({ level: 3 })"
                >
                    H3
                </button>
            </div>
        </editor-menu-bar>
        <editor-menu-bubble
            class="menububble"
            :editor="editor"
            @hide="hideLinkMenu"
            v-slot="{ commands, isActive, getMarkAttrs, menu }"
        >
            <div
                class="menububble"
                :class="{ 'is-active': menu.isActive }"
                :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
            >

                <form
                    class="menububble__form"
                    v-if="linkMenuIsActive"
                    @submit.prevent="setLinkUrl(commands.link, linkUrl, linkTarget)"
                >
                    <input
                        class="menububble__input"
                        type="text"
                        v-model="linkUrl"
                        placeholder="https://"
                        ref="linkInput"
                        @keydown.esc="hideLinkMenu"
                    />

                    <span class="text-white m-2">Esterno?</span>
                    <span class="switch">
                        <input
                            type="checkbox"
                            class="switch"
                            id="link-target"
                            v-model="linkTarget"
                        />
                        <label for="link-target"></label>
                    </span>
                    <button
                        class="menububble__button"
                        @click="setLinkUrl(commands.link, null)"
                        type="button"
                    >
                        Elimina
                    </button>
                </form>

                <template v-else>
                    <button
                        class="menububble__button"
                        @click="showLinkMenu(getMarkAttrs('link'))"
                        :class="{ 'is-active': isActive.link() }"
                    >
                        <span>{{ isActive.link() ? 'Modifica Link' : 'Aggiungi Link'}}</span>
                    </button>
                </template>
            </div>
        </editor-menu-bubble>
        <editor-content
            class="a-text-editor__content"
            :editor="editor"
        >
        </editor-content>
    </div>
</div>
</template>

<script>
import {
    Editor,
    EditorContent,
    EditorMenuBar,
    EditorMenuBubble,
}
from 'tiptap'


import {
    Blockquote,
    CodeBlock,
    HardBreak,
    Heading,
    HorizontalRule,
    OrderedList,
    BulletList,
    ListItem,
    TodoItem,
    TodoList,
    Bold,
    Code,
    Italic,
    Strike,
    Underline,
    History,
}
from 'tiptap-extensions'

import Iframe from './plugins/Iframe'
import Link from './plugins/Link'
import Image from './plugins/Image'

export default {
    name: 'TextEditor',
    props: {
        label: {
            type: String,
            default: 'Titolo',
        },
        hasLabel: {
            type: Boolean,
            default: false,
        },
        initial: {
            type: String,
            default: null,
        },
    },
    components: {
        EditorContent,
        EditorMenuBar,
        EditorMenuBubble,
    },
    data: function () {
        return {
            editor: null,
            html: null,
            json: null,
            linkUrl: null,
            linkTarget: null,
            linkMenuIsActive: false,
        }
    },
    watch: {
        initial: function (initial) {
            if (this.editor) {
                this.editor.setContent(initial)
                this.$nextTick(() => {
                    this.html = this.editor.getHTML()
                    this.json = this.editor.getJSON()
                    this.$emit('update', this.json, this.html)
                })
            }
        }
    },
    methods: {
        init: function () {
            this.editor = new Editor({
                extensions: [
                    new Blockquote(),
                    new Bold(),
                    new BulletList(),
                    new Code(),
                    new CodeBlock(),
                    new HardBreak(),
                    new Heading({
                        levels: [1, 2, 3]
                    }),
                    new Iframe(),
                    new History(),
                    new HorizontalRule(),
                    new Image(),
                    new Italic(),
                    new Link(),
                    new ListItem(),
                    new OrderedList(),
                    new Strike(),
                    new TodoItem(),
                    new TodoList(),
                    new Underline(),
                ],
                content: this.initial ? this.initial : '',
            })

            this.editor.on('update', (e) => {
                this.html = e.getHTML()
                this.json = e.getJSON()
                this.$emit('update', this.json, this.html)
            })

            if (this.initial) {
                this.html = this.editor.getHTML()
                this.json = this.editor.getJSON()
                this.$emit('update', this.json, this.html)
            }
        },
        showLinkMenu: function (attrs) {
            console.log('show link menu');
            this.linkUrl = attrs.href
            this.linkTarget = attrs.href
            this.linkMenuIsActive = true
            this.$nextTick(() => {
                this.$refs.linkInput.focus()
            })
        },
        hideLinkMenu: function () {
            this.linkUrl = null
            this.linkTarget = null
            this.linkMenuIsActive = false
        },
        setLinkUrl: function (command, url, target) {
            let formattedTarget = '_self'
            if (target) {
                formattedTarget = '_blank'
            }

            command({
                href: url,
                target: formattedTarget
            })
            this.hideLinkMenu()
            this.editor.focus()
        },
        focusEditor: function () {
            if (this.editor) {
                this.editor.focus()
            }
        },
        showImagePrompt: function (command) {
            let src = prompt('Inserire l\'url dell\'immagine')
            if (src !== null) {
                command({
                    src
                })
            }
        },
    },
    mounted: function () {
        this.$nextTick(this.init)
    },
    beforeDestroy: function () {
        this.editor.destroy()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';
@import '~styles/vendor/tiptap/main';

.a-text-editor {
    &__container {
        max-width: 100%;
        margin: 0;
        background-color: $gray-100;
        @include border-radius(10px);
        padding: $spacer;
        min-height: 40vh;
        box-shadow: $input-box-shadow;
        background-image: none;
        background-clip: padding-box;
        border: $input-btn-border-width solid $input-border-color;
        transition: $transition-base;

        .menubar {
            display: flex;
        }

        &__content {
            min-height: 40vh;
        }

        img {
            max-width: 100%;
        }
    }
}

.ProseMirror-focused {
    outline: none;
}
</style>
