<template>
<div
    class="block-panel"
    ref="parent"
>
    <div
        class="block-panel__head"
        ref="head"
    >
        <ui-title
            :title="title"
            tag="h2"
            font-size="h2"
            class="block-panel__title"
            :has-container="false"
            :has-margin="false"
        />
        <ui-button
            :title="panelBtn"
            theme="outline"
            class="block-panel__top-btn"
            :has-container="false"
            :has-margin="false"
            display="inline-block"
            @click="togglePanel"
        />
    </div>
    <div
        class="block-panel__container"
        ref="container"
    >
        <slot></slot>
    </div>
</div>
</template>

<script>
import {
    UiTitle,
    UiButton,
}
from '../../ui'

import {
    TweenMax,
    TimelineMax,
    Power4,
    Power0,
    CSSPlugin,
    Elastic,
    Back,
    Sine,
}
from 'gsap/all'


import {
    GSDevTools
}
from 'gsap/GSDevTools'

const plugins = [
    Power4,
    Power0,
    CSSPlugin,
    Elastic,
    Back,
    Sine,
]

export default {
    name: 'BlockPanel',
    components: {
        UiButton,
        UiTitle,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        hasDebug: {
            type: Boolean,
            default: false,
        },
        needsTriggger: {
            type: Boolean,
            default: false
        },
    },
    data: function () {
        return {
            isOpen: false,
            master: null,
        }
    },
    computed: {
        panelBtn: function () {
            if (this.isOpen) {
                return 'Riduci'
            }
            else {
                return 'Espandi'
            }
        },
        uuid: function () {
            return this.$util.uuid()
        },
    },
    methods: {
        trigger: function () {
            this.initAnim()
        },
        getChildNodes: function (node) {
            // https://stackoverflow.com/questions/593785/get-elements-just-1-level-below-the-current-element-by-javascript
            let children = new Array();
            for (let child in node.childNodes) {
                if (node.childNodes[child].nodeType == 1) {
                    console.log(child);
                    children.push(child);
                }
            }

            console.log(node, children);
            return children;
        },
        isVisible: function (el) {
            //https://stackoverflow.com/questions/44612141/get-only-visible-element-using-pure-javascript
            while (el) {
                if (el === document) {
                    return true;
                }

                let $style = window.getComputedStyle(el, null);

                if (!el) {
                    return false;
                }
                else if (!$style) {
                    return false;
                }
                else if ($style.display === 'none') {
                    return false;
                }
                else if ($style.visibility === 'hidden') {
                    return false;
                }
                else if (+$style.opacity === 0) {
                    return false;
                }
                else if (($style.display === 'block' || $style.display === 'inline-block') &&
                    $style.height === '0px' && $style.overflow === 'hidden') {
                    return false;
                }
                else {
                    return $style.position === 'fixed' || this.isVisible(el.parentNode);
                }
            }
        },
        initAnim: function () {
            let parent = this.$parent.$el
            let head = this.$refs.head
            let content = this.$refs.container
            let childs = content.children
            let childsVisible = []

            parent = parent.parentNode

            for (let i = 0; i < childs.length; i++) {
                let child = childs[i]
                if (this.isVisible(child)) {
                    childsVisible.push(child)
                }
            }

            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start', 0)
            this.master.addLabel('setInitial', 'start')
            this.master.addLabel('setWidth', 'start+=0.1')
            this.master.addLabel('setHeight', 'start+=0.15')
            this.master.addLabel('revealFrame', 'start+=0.35')
            this.master.addLabel('revealContent', 'start+=0.45')

            this.master.fromTo(content, .1, {
                    display: 'none',
                }, {
                    display: 'block',
                }, 'start')

                .set(childsVisible, {
                    opacity: '0',
                }, 'start')
                .set(this.$refs.parent, {
                    display: 'flex',
                }, 'start')

                .set(content, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    overflow: 'hidden',
                }, 'start')

                .set(content, {
                    id: 'width',
                    width: '100%',
                    maxWidth: '100%',
                }, 'setWidth')
                .from(content, 0.1, {
                    width: '1px',
                    maxWidth: '0%',
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                    immediateRender: false,
                }, 'setWidth')

                .set(content, {
                    id: 'height',
                    height: 'auto',
                    paddingTop: '3.236rem',
                    paddingBottom: '1.618rem',
                }, 'setHeight')
                .from(content, .1, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    immediateRender: false,
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                }, 'setHeight')

                .fromTo(content, .2, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: Power4.eeaseInOut,
                    immediateRender: false,
                }, 'setInitial')

                .fromTo(head, .3, {
                    paddingBottom: '0',
                }, {
                    paddingBottom: '1.618rem',
                    immediateRender: false,
                }, 'start')

                .fromTo(parent, .1, {
                    paddingBottom: '2rem',
                }, {
                    paddingBottom: '3.236rem',
                    immediateRender: false,
                }, 'setHeight+=0.05')

                .fromTo(content, .1, {
                    borderWidth: '0',
                }, {
                    id: 'boders',
                    borderWidth: '3px',
                    ease: Power4.easeInOut,
                    immediateRender: false,
                }, 'revealFrame')

                .set(content, {
                    id: 'shadows',
                    boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0.2)',
                }, 'revealFrame')
                .from(content, .2, {
                    boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0)',
                    immediateRender: false,
                    // ease: Power4.easeInOut,
                    ease: Sine.easeInOut,
                }, 'revealFrame')


                .fromTo(childsVisible, .15, {
                    opacity: '0',
                    scaleX: 0.9,
                    scaleY: 1.1,
                }, {
                    opacity: '1',
                    scaleX: 1,
                    scaleY: 1,
                    stagger: 0.1,
                    ease: Sine.easeOut,
                    immediateRender: false,
                }, 'revealContent')

            // if (this.hasDebug) {
            //     GSDevTools.create({
            //         animation: this.master,
            //         inTime: 'revealFrame-=0.1',
            //         css: {
            //             zIndex: 999,
            //         }
            //     })
            // }

            this.$nextTick(() => {
                this.togglePanel()
            })
        },
        togglePanel: function () {
            if (this.master) {
                if (this.isOpen) {
                    // chiude pannello
                    this.$ebus.$emit('add-anim', this.master, false, this.uuid, () => {
                        this.isOpen = false
                    })
                }
                else {
                    // apre pannello
                    this.$ebus.$emit('add-anim', this.master, true, this.uuid, () => {
                        this.isOpen = true
                    })
                }
            }
        },
    },
    mounted: function () {

        if (this.needsTrigger == false) {
            this.$nextTick(() => {
                this.initAnim()
            })
        }
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
.block-panel {
    $color: $gray-100;

    &__top-btn {
        color: darken($color, 50);
        border: 1px solid darken($color, 50);

        &:hover {
            background-color: darken($color, 50);
            color: $color;
        }
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
.block-panel {
    $color: $gray-100;
    // display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    // width: 100%;
    // max-width: 100%;

    &__head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 0 ($spacer * 1.618) 0;
    }

    &__title {
        display: inline-block;
        color: darken($color, 50);
        letter-spacing: 12px;
        padding: 0;
        // @include title-text-shadow(12px, 1px, 1px, 2px, 0.33);
    }

    &__container {
        width: 100%;
        border: 3px solid darken($color, 6);
        background-color: $color;
        padding: ($spacer * 2 * 1.618) ($spacer * 2 * 1.618) ($spacer * 1.618) ($spacer * 2 * 1.618);
        @include border-radius($border-radius * 2);
        // @include custom-inner-shadow(darken($color, 30), 8px, 0.2);
        // @include gradient-directional($color, lighten($color, 2), -10deg);
        // @include custom-box-shadow(lighten($dark, 25), 1px, 0.3);
    }
}
</style>
