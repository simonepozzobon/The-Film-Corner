<template>
<div class="admin-editor">
    <div class="custom-text">
        <label
            class="custom-text__label"
            for=""
        >
            {{ label }}
        </label>
        <div
            class="custom-text__area"
            ref="container"
            @click.stop.prevent="focusEditor"
        >
            <editor-menu-bar
                ref="menuBar"
                :editor="editor"
                v-slot="{ commands, isActive }"
            >
                <div class="custom-text-menu">
                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.bold() }"
                        @click="commands.bold"
                    >
                        B
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.italic() }"
                        @click="commands.italic"
                    >
                        I
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.strike() }"
                        @click="commands.strike"
                    >
                        S
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.underline() }"
                        @click="commands.underline"
                    >
                        U
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.bullet_list() }"
                        @click="commands.bullet_list"
                    >
                        List
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.heading({ level: 1 }) }"
                        @click="commands.heading({ level: 1 })"
                    >
                        H1
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.heading({ level: 2 }) }"
                        @click="commands.heading({ level: 2 })"
                    >
                        H2
                    </button>

                    <button
                        class="custom-text-menu__button"
                        :class="{ 'custom-text-menu__button--active': isActive.heading({ level: 3 }) }"
                        @click="commands.heading({ level: 3 })"
                    >
                        H3
                    </button>

                </div>
            </editor-menu-bar>
            <editor-menu-bubble
                :editor="editor"
                @hide="hideLinkMenu"
                v-slot="{ commands, isActive, getMarkAttrs, menu }"
            >
                <div
                    class="custom-menububble"
                    :class="{ 'custom-menububble--active': menu.isActive }"
                    :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
                >
                    <form
                        class="custom-menububble__form"
                        v-if="linkMenuIsActive"
                        @submit.prevent="setLinkUrl(commands.link, linkUrl)"
                    >
                        <input
                            class="custom-menububble__input"
                            type="text"
                            v-model="linkUrl"
                            placeholder="https://"
                            ref="linkInput"
                            @keydown.esc="hideLinkMenu"
                        />
                        <button
                            class="custom-menububble__button"
                            @click="setLinkUrl(commands.link, null)"
                            type="button"
                        >
                            Elimina
                        </button>
                    </form>

                    <template v-else>
                        <button
                            class="custom-menububble__button"
                            @click="showLinkMenu(getMarkAttrs('link'))"
                            :class="{ 'custom-menububble__button--active': isActive.link() }"
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
    TweenMax,
    Power4,
    TimelineMax,
}
from 'gsap/all'

const plugins = [
    Power4,
]

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
                content: this.initial ? this.initial : 'testo di prova',
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

            this.$nextTick(() => {
                this.closePanel()
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
@import '~styles/buttons';
@import '~styles/utilities/conversion';

$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

// colors
$ci-bg: $color-darken;
$ci-color: darken($ci-bg, 25);
$ci-btn-color: $ci-color;
$ci-btn-color-active: $ci-bg;

// fonts
$ci-font-size: $font-size-base;
$ci-label-font-size: $ci-font-size * .8;
$ci-btn-font-size: $ci-font-size * .7;

// label font
$ci-label-font-weight: 600;
$ci-label-letter-spacing: 5px;

// measurements
$ci-shift-x: $spacer * 1.618 * 0.6;
$ci-shift-y: $spacer * 1.618 * 0.5;
$ci-small: 0.8;

// input borders
$ci-border-color: darken($ci-bg, 5);
$ci-border-radius: $border-radius * 2;
$ci-border-size: $spacer / 10;

// Label position
$ci-font-size-spacer: $ci-font-size * 1.2;
$ci-label-top: $ci-border-size + ($ci-font-size-spacer / 2);
$ci-label-left: $ci-border-size + $ci-shift-x;

// padding
$ci-padding-x: $ci-shift-x;
$ci-padding-y: $ci-shift-y;

$ci-padding-top: $ci-label-top + $ci-font-size-spacer;
$ci-padding-right: $ci-padding-x;
$ci-padding-bottom: $ci-label-top;
$ci-padding-left: $ci-padding-x;

// shadows
$i-x: -3px;
$i-y: -3px;
$i-blur: 72px;
$i-spread: -70px;
$i-opacity: 0.7;
$ci-shadow-color: lighten($ci-border-color, 1);
$i-color: invert($ci-shadow-color);

// transitions
$ci-transition: all 0.1s linear;
$ci-transition-label: all 0.1s ease-in-out;

// measurements when focused
$ci-label-font-size-focused: $ci-label-font-size * $ci-small;
// $ci-font-size-focused: $ci-font-size * (1 / $ci-small);
$ci-font-size-focused: $ci-font-size;

// $ci-padding-top-focused: $ci-padding-top * $ci-small;
$ci-padding-top-focused: $ci-padding-top;

// @debug unquote('testo') rem-to-px($ci-font-size) unquote(' -> ') rem-to-px($ci-font-size-focused);
// @debug unquote('label') $ci-label-font-size unquote(' -> ') $ci-label-font-size-focused;
// @debug unquote('padding-top') rem-to-px($ci-padding-top) unquote(' -> ') rem-to-px($ci-padding-top-focused);

// styles
.custom-text {
    position: relative;

    &__label {
        position: absolute;
        top: $ci-label-top;
        left: $ci-label-left;
        color: darken($ci-color, 10);
        font-size: $ci-label-font-size;
        font-weight: $ci-label-font-weight;
        text-transform: uppercase;
        letter-spacing: $ci-label-letter-spacing;
        transform-origin: left top;
        line-height: 1;

        transition: $ci-transition-label;
    }

    &__area {
        @include border-radius($ci-border-radius);
        width: 100%;
        padding: $ci-padding-top $ci-padding-right $ci-padding-bottom $ci-padding-left;
        color: $ci-color;
        font-size: $ci-font-size;
        background-color: $ci-bg;
        @include gradient-directional(lighten($ci-bg, 2), lighten($ci-bg, 3), -5deg);
        border: $ci-border-size solid $ci-border-color;
        box-shadow: inset $i-x $i-y $i-blur $i-spread rgba($i-color, $i-opacity), 2px 4px 12px -2px rgba($i-color, 0.02), 4px 8px 24px -4px rgba($i-color, 0.04);
        line-height: 1;
        transition: $ci-transition;

        &:focus {
            padding-top: $ci-padding-top-focused;
            color: darken($ci-color, 10);
            font-size: $ci-font-size-focused;
            border-color: darken($ci-border-color, 4);
            outline: none;
            transition: $ci-transition;
        }

    }

    &:focus-within &__label,
    &__input:focus + &__label {
        color: lighten($ci-color, 10);
        // font-size: $ci-label-font-size-focused;
        transform: scale($ci-small);
        transition: $ci-transition-label;
    }
}

.custom-text-menu {
    display: flex;
    background-color: $ci-bg;
    padding: ($ci-shift-x * $ci-small) ($ci-shift-y * $ci-small);
    @include border-radius($ci-border-radius);
    margin-bottom: $ci-shift-y;

    &__button {
        @extend .btn;
        @extend .btn-sm;
        text-transform: uppercase;
        font-size: $ci-btn-font-size;
        font-weight: 600;

        color: $ci-btn-color;
        border-color: $ci-btn-color;

        &:hover {
            color: $ci-btn-color-active;
            background-color: $ci-color;
            border-color: lighten($ci-btn-color, 10);
        }

        & + & {
            margin-left: $ci-shift-x;
        }

        &--active {
            color: lighten($ci-bg, 10);
            background-color: lighten($ci-color, 10);
            border-color: lighten($ci-btn-color, 10);
        }
    }
}

.custom-menububble {
    position: absolute;

    &--active {
        display: block;
    }
}

.ProseMirror-focused {
    outline: none;
}
</style>
