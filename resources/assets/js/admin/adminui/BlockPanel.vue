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
    gsap,
    TimelineMax,
    Power4,
    Power0,
    CSSPlugin,
    Elastic,
    Back,
    Sine,
}
from 'gsap'


import {
    GSDevTools
}
from 'gsap/GSDevTools'

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
        }
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
    },
    methods: {
        // https://stackoverflow.com/questions/593785/get-elements-just-1-level-below-the-current-element-by-javascript
        getChildNodes: function (node) {
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
        //https://stackoverflow.com/questions/44612141/get-only-visible-element-using-pure-javascript
        isVisible: function (el) {
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

            this.master.fromTo(content, .1, {
                    display: 'none',
                }, {
                    display: 'block',
                }, 0)
                .set(childsVisible, {
                    opacity: '0',
                }, .1)
                .set(this.$refs.parent, {
                    display: 'flex',
                }, .1)
                .set(content, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    overflow: 'hidden',
                    width: '100%',
                    maxWidth: '100%',
                }, .11)
                .from(content, 0.15, {
                    width: '1px',
                    maxWidth: '0%',
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                    immediateRender: false,
                }, .11)

                .set(content, {
                    height: 'auto',
                    paddingTop: '3.236rem',
                    paddingBottom: '1.618rem',
                }, .15)
                .from(content, 0.15, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    immediateRender: false,
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                }, .15)

                .fromTo(content, .45, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: Sine.easeOut,
                    immediateRender: false,
                }, .2)

                .fromTo(childsVisible, .25, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    immediateRender: false,
                }, .35)

                .fromTo(head, .3, {
                    paddingBottom: '0',
                }, {
                    paddingBottom: '1.618rem',
                    immediateRender: false,
                }, .1)

                .fromTo(parent, .15, {
                    paddingBottom: '2rem',
                }, {
                    paddingBottom: '3.236rem',
                    immediateRender: false,
                }, .3)

                .set(content, {
                    boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0.2)',
                }, .55)
                .from(content, .2, {
                    boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0)',
                    immediateRender: false,
                    ease: Sine.easeOut,
                }, .55)

            if (this.hasDebug) {
                GSDevTools.create({
                    animation: this.master
                })
            }

            this.master.eventCallback('onComplete', () => {
                this.isOpen = true
            })

            this.master.eventCallback('onReverseComplete', () => {
                this.isOpen = false
            })

            this.$nextTick(() => {
                this.togglePanel()
            })
        },
        togglePanel: function () {
            if (this.master) {
                if (this.isOpen) {
                    this.master.reverse()
                }
                else {
                    this.master.play()
                }
            }
        },
        showPanel: function () {
            if (this.master) {
                this.master.play()
            }
        },
        hidePanel: function () {
            if (this.master) {
                this.master.reverse()
            }
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.initAnim()
        })
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
