<template>
<div
    class="ui-paragraph"
    :class="[
            sizeClass,
            alignClass,
            noPaddingClass,
            padding,
            fullWidthClass,
            colorClass,
        ]"
>
    <div
        v-for="(item, i) in items"
        :key="i"
    >
        <component
            v-if="item.component"
            :is="item.component"
            v-bind="item.attrs"
        ></component>
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
}
from 'tiptap-extensions'

import UiTitle from './UiTitle'
import CustomContent from './CustomContent'

export default {
    name: 'UiParagraph',
    props: {
        align: {
            type: String,
            default: null,
        },
        hasPadding: {
            type: Boolean,
            default: true,
        },
        padding: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: null,
        },
        size: {
            type: String,
            default: null,
        },
        fullWidth: {
            type: Boolean,
            default: false,
        },
        html: {
            type: String,
            default: null,
        },
    },
    components: {
        UiTitle
    },
    data: function () {
        return {
            items: [],
        }
    },
    computed: {
        alignClass: function () {
            if (this.align == 'center') {
                return 'ui-paragraph--align-center'
            }
            else if (this.align == 'justify') {
                return 'ui-paragraph--align-justify'
            }
            return null
        },
        noPaddingClass: function () {
            if (!this.hasPadding) {
                return 'ui-paragraph--no-padding'
            }
        },
        colorClass: function () {
            if (this.color) {
                return 'text-' + this.color
            }
        },
        sizeClass: function () {
            if (this.size) {
                return 'ui-paragraph--size-' + this.size
            }
        },
        fullWidthClass: function () {
            if (this.fullWidth) {
                return 'ui-paragraph--full-width'
            }
        },
    },
    methods: {
        init: function () {
            // console.log(this.html);
            let editor = new Editor({
                extensions: [
                    // new PasteHandler(),
                    // new EnterHandler(),
                    new Blockquote(),
                    new BulletList(),
                    new CodeBlock(),
                    new HardBreak(),
                    // new Heading({
                    //     levels: [1, 2, 3]
                    // }),
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
                    new Heading(),

                ],
                content: this.html ? this.html : '',
            })

            let json = editor.getJSON()
            let flattened = this.flatten(json)
            console.log('flattened', flattened);
            let formatted = this.formattedJson(flattened)
            this.items = formatted
            // console.log(formatted);
            // editor.setContent(formatted, true)
        },
        flatten: function (Obj) {
            let buf
            if (Obj instanceof Array) {
                let flat = Obj.flat()
                let formatted = this.formattedJson(flat)
                console.log(Obj, typeof formatted);
                return formatted
            }
            else if (Obj instanceof Object) {

                buf = {} // create an empty object

                // buf[k] = this.flatten(Obj[k]) // recursively clone the value
                return buf
            }
            else {
                return Obj
            }
        },
        formattedJson: function (Obj) {
            let buf
            if (Obj instanceof Array) {
                buf = [] // create an empty array
                let i = Obj.length
                while (i--) {
                    buf[i] = this.formattedJson(Obj[i]) // recursively clone the elements
                }
                return buf
            }
            else if (Obj instanceof Object) {
                buf = {} // create an empty object

                for (let k in Obj) {
                    if (k == 'type') {
                        let newObj
                        switch (Obj[k]) {
                        case 'heading':
                            newObj = this.formatHeading(Obj)
                            return this.formattedJson(newObj)
                            break;
                        case 'image':
                            newObj = this.formattedImage(Obj)
                            return this.formattedJson(newObj)
                            break;
                        default:
                        }
                    }
                    buf[k] = this.formattedJson(Obj[k]) // recursively clone the value
                }
                return buf
            }
            else {
                return Obj
            }
        },
        formatHeading: function (obj) {
            let level = 'h' + obj.attrs.level
            let content = obj.content[0].text
            let component = 'ui-title'
            let attrs = {
                title: content,
                tag: level,
                fontSize: level,
            }

            return {
                type: 'ui-title',
                component: component,
                attrs: attrs,
                content: obj.content
            }
        },
        formattedParagraph: function (obj) {
            let component = 'ui-paragraph'
            return obj
        },
        formattedImage: function (obj) {
            return {
                type: 'ui-image',
                component: 'ui-image',
                attrs: {
                    src: obj.attrs.src,
                    alt: obj.attrs.alt,
                    title: obj.attrs.title,
                }
            }
        },
    },
    beforeCreate: function () {
        this.$options.components.UiTitle = require('./UiTitle.vue').default
        this.$options.components.UiParagraph = require('./UiParagraph.vue').default
        this.$options.components.UiImage = require('./UiImage.vue').default
    },
    mounted: function () {
        this.init()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-paragraph {
    $self: &;
    padding-left: $spacer * 4;
    padding-right: $spacer * 4;
    margin-bottom: $spacer * 1.5;
    z-index: 1;

    &__content {
        padding: 0;
        margin: 0;
    }

    &--align-center {
        text-align: center;
    }

    &--no-padding {
        padding-left: 0;
        padding-right: 0;
    }

    &--size-small {
        font-size: $font-size-sm;
    }

    &--size-lg {
        font-size: $font-size-lg;
    }

    &--align-justify {
        text-align: justify;
    }

    &--full-width {
        width: 100%;
    }
}
</style>
