<template>
<div class="block-panel">
    <div class="block-panel__head">
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
}
from 'gsap'

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
    },
    data: function () {
        return {
            isOpen: true,
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
        initAnim: function () {
            let container = this.$refs.container
            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(container, .6, {
                height: 0,
                overflow: 'hidden',
                position: 'absolute',
                autoAlpha: 0,
                ease: Power4.easeInOut,
            }, {
                height: 'auto',
                overflow: 'auto',
                position: 'inherit',
                autoAlpha: 1,
                ease: Power4.easeInOut,
            })

            this.master.progress(1).progress(0)

            this.master.eventCallback('onComplete', () => {
                this.isOpen = true
            })

            this.master.eventCallback('onReverseComplete', () => {
                this.isOpen = false
            })

            if (this.isOpen == true) {
                this.$nextTick(() => {
                    this.showPanel()
                })
            }
        },
        togglePanel: function () {
            if (this.isOpen) {
                this.hidePanel()
            }
            else {
                this.showPanel()
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
        background-color: $color;
        padding: ($spacer * 2 * 1.618) ($spacer * 2 * 1.618) ($spacer * 1.618) ($spacer * 2 * 1.618);
        border: 3px solid darken($color, 6);
        @include border-radius($border-radius * 2);
        @include custom-inner-shadow(darken($color, 30), 8px, 0.2);
        // @include gradient-directional($color, lighten($color, 2), -10deg);
        // @include custom-box-shadow(lighten($dark, 25), 1px, 0.3);
    }
}
</style>
