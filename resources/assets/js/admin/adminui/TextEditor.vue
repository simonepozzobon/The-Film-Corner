<template>
<div class="admin-editor">
    <div class="form-group row">
        <label
            for=""
            class="col-md-2"
        >
            {{ label }}
        </label>
        <div
            class="col-md-10"
            @click.prevent="focusEditor"
        >
            <div
                class="admin-editor__container"
                ref="container"
            >
                <editor-menu-bar
                    ref="menuBar"
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

                        <button
                            class="menubar__button"
                            :class="{ 'is-active': isActive.bullet_list() }"
                            @click="commands.bullet_list"
                        >
                            List
                        </button>

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
                            @submit.prevent="setLinkUrl(commands.link, linkUrl)"
                        >
                            <input
                                class="menububble__input"
                                type="text"
                                v-model="linkUrl"
                                placeholder="https://"
                                ref="linkInput"
                                @keydown.esc="hideLinkMenu"
                            />
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
                    class="admin-editor__content"
                    :editor="editor"
                >
                </editor-content>
            </div>
        </div>
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
    TimelineMax,
    Power4,
}
from 'gsap'

import {
    Blockquote,
    CodeBlock,
    HardBreak,
    Heading,
    HorizontalRule,
    OrderedList,
    BulletList,
    Image,
    ListItem,
    TodoItem,
    TodoList,
    Bold,
    Code,
    Italic,
    Link,
    Strike,
    Underline,
    History,
    Focus,
}
from 'tiptap-extensions'

export default {
    name: 'TextEditor',
    props: {
        label: {
            type: String,
            default: 'Titolo',
        },
        hasAnimation: {
            type: Boolean,
            default: false,
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
            linkMenuIsActive: false,
            master: null,
            isOpen: false,
        }
    },
    methods: {
        init: function () {
            this.editor = new Editor({
                extensions: [
                    // new PasteHandler(),
                    // new EnterHandler(),
                    new Blockquote(),
                    new BulletList(),
                    new CodeBlock(),
                    new HardBreak(),
                    new Heading({
                        levels: [1, 2, 3]
                    }),
                    new Image(),
                    new HorizontalRule(),
                    new ListItem(),
                    new OrderedList(),
                    new TodoItem(),
                    new TodoList(),
                    new Link(),
                    new Bold(),
                    new Code(),
                    new Italic(),
                    new Strike(),
                    new Underline(),
                    new History(),
                    new Focus({
                        className: 'has-focus',
                        nested: true,
                    }),
                ],
                content: this.initial ? this.initial : '',
                onFocus: () => {
                    if (this.hasAnimation) {
                        this.openPanel()
                    }
                },
                onBlur: () => {
                    if (this.hasAnimation) {
                        this.closePanel()
                    }
                }
            })

            // console.log(this.initial);

            this.editor.on('update', (e) => {
                this.html = e.getHTML()
                this.json = e.getJSON()
                this.$emit('update', this.json, this.html)
                // console.log('updated');
            })

            if (this.hasAnimation == true) {
                this.$nextTick(() => {
                    this.initAnim()
                })
            }
        },
        initAnim: function () {
            let container = this.$refs.container
            let menu = container.getElementsByClassName('menubar')
            if (menu) {
                menu = menu[0]
            }

            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(container, .3, {
                    minHeight: '40vh',
                    ease: Power4.easeInOut,
                }, {
                    minHeight: '30px',
                    ease: Power4.easeInOut,
                }, 0)
                .fromTo(menu, .2, {
                    immediateRender: false,
                    autoAlpha: 1,
                    ease: Power4.easeInOut,
                }, {
                    autoAlpha: 0,
                    ease: Power4.easeInOut,
                }, 0)
                .progress(1)
                .progress(0)
                .then(() => {
                    this.$nextTick(() => {
                        this.closePanel()
                    })
                })



        },
        closePanel: function () {
            if (this.master) {
                this.master.play()
            }
        },
        openPanel: function () {
            if (this.master) {
                this.master.reverse()
            }
        },
        showLinkMenu: function (attrs) {
            this.linkUrl = attrs.href
            this.linkMenuIsActive = true
            this.$nextTick(() => {
                this.$refs.linkInput.focus()
            })
        },
        hideLinkMenu: function () {
            this.linkUrl = null
            this.linkMenuIsActive = false
        },
        setLinkUrl: function (command, url) {
            command({
                href: url
            })
            this.hideLinkMenu()
            this.editor.focus()
        },
        focusEditor: function () {
            if (this.editor) {
                this.editor.focus()
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

.admin-editor {
    &__container {
        max-width: 100%;
        margin: 0;
        background-color: rgba($white, 0.5);
        @include border-radius(10px);
        padding: $spacer;
        border: $input-border-width solid $input-border-color;
        min-height: 40vh;

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
