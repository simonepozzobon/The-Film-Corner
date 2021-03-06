<template>
<div
    class="block-panel"
    :class="[shadowClass, hasAnimationsClass]"
    ref="parent"
>
    <div
        class="block-panel__head"
        ref="head"
    >
        <ui-title
            :title="title"
            :tag="titleSize"
            :font-size="titleSize"
            class="block-panel__title"
            :has-container="false"
            :has-margin="false"
        />
        <ui-button
            v-if="hasAnimations"
            :title="panelBtn"
            theme="outline"
            class="block-panel__top-btn"
            :has-container="false"
            :has-margin="false"
            display="inline-block"
            @click="toggleAnim"
        />
    </div>
    <div
        class="block-panel__container"
        ref="container"
    >
        <slot></slot>
    </div>

    <div
        v-if="hasFooter"
        class="block-panel__footer"
    >
        <slot name="footer"></slot>
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
    BlockPanelAnimation,
}
from './mixins'

export default {
    name: 'BlockPanel',
    mixins: [BlockPanelAnimation],
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
        needsTrigger: {
            type: Boolean,
            default: false
        },
        needsFlex: {
            type: Boolean,
            default: false,
        },
        hasAnimations: {
            type: Boolean,
            default: true,
        },
        initialState: {
            type: Boolean,
            default: false,
        },
        hasFooter: {
            type: Boolean,
            default: false,
        },
        titleSize: {
            type: String,
            default: 'h2',
        },
        noParent: {
            type: Boolean,
            default: false,
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
        shadowClass: function () {
            if (this.hasAnimations == false) {
                return 'block-panel--shadows'
            }
            return null
        },
        hasAnimationsClass: function () {
            if (this.hasAnimations == false) {
                return 'block-panel--no-animations'
            }
            return null
        }
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
                    // console.log(child);
                    children.push(child);
                }
            }

            // console.log(node, children);
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
        togglePanel: function () {
            console.log('deprecata');
        },
        toggleAnim: function () {
            if (this.master) {
                if (this.isOpen == true) {
                    this.isOpen = false
                    this.master.reverse()
                }
                else if (this.isOpen == false) {
                    // apre pannello
                    this.isOpen = true
                    this.master.play()
                }
            }
        }
    },
    mounted: function () {
        // console.log('mounted', this.title);
        if (this.needsTrigger == false && this.hasAnimations == true) {
            this.initAnim()
        }
        else {
            // console.log('ha bisogno di trigger', this.title);
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
        padding: 0;
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
        padding: ($spacer * 1.618) ($spacer * 1.618) ($spacer * 1.618) ($spacer * 1.618);
        @include border-radius($border-radius * 2);

        flex-direction: column;
        align-items: center;
        justify-content: center;

        // @include gradient-directional($color, lighten($color, 2), -10deg);
        // @include custom-box-shadow(lighten($dark, 25), 1px, 0.3);
    }

    &__footer {
        margin-top: $spacer;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    &--shadows &__container {
        @include custom-inner-shadow(darken($color, 30), 8px, 0.2);
    }

    &--no-animations &__container {
        margin-top: $spacer * 1.618;
    }
}
</style>
