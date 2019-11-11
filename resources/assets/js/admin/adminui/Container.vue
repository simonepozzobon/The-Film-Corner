<template>
<div
    class="admin-container"
    :class="[paddingClass, containsClass]"
    ref="container"
>
    <div class="admin-container__content">
        <slot></slot>
    </div>
</div>
</template>

<script>
import {
    gsap,
    TweenMax,
    TimelineMax,
    Power4,
}
from 'gsap/all'

const plugins = [
    Power4,
]

export default {
    name: 'Container',
    props: {
        padding: {
            type: String,
            default: null,
        },
        hasAnimations: {
            type: Boolean,
            default: false,
        },
        state: {
            type: Boolean,
            default: false,
        },
        contains: {
            type: Boolean,
            default: false,
        },
        hasDebug: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            master: null
        }
    },
    computed: {
        uuid: function () {
            return this.$util.uuid()
        },
        paddingClass: function () {
            if (this.padding) {
                return 'admin-container--padding-' + this.padding
            }
            else {
                return null
            }
        },
        containsClass: function () {
            if (this.contains) {
                return 'admin-container--contains'
            }
            else {
                return null
            }
        }
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container
            let master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            master.to(container, .1, {
                    overflow: 'hidden',
                }, 'start')
                .fromTo(container, .6, {
                    height: '1px',
                    autoAlpha: 0,
                    ease: Power4.easeInOut,
                }, {
                    autoAlpha: 1,
                    height: 'auto',
                    ease: Power4.easeInOut,
                    immediateRender: false,
                }, 'start+=0')
                .to(container, .1, {
                    overflow: 'inherit'
                }, 'start+=0.6')

            master.progress(1).progress(0)

            master.eventCallback('onComplete', () => {
                gsap.set(container, {
                    clearProps: 'all'
                })
                master.kill()
                this.$emit('completed')
            })

            master.play()
        },
        setState: function () {
            console.log('deprecata');
        },
        showPanel: function () {
            console.log('deprecata');
        },
        hidePanel: function () {
            console.log('deprecata');
        },
    },
    mounted: function () {
        if (this.hasAnimations == true) {
            this.initAnim()
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
$color-darken: lighten($light, 3);
$darken: lighten($dark, 3);

.admin-container {
    &__content {
        // background-color: $gray-100;
        padding: ($spacer * 2) ($spacer * 2 * 1.618) ($spacer * 2 * 1.618) ($spacer * 2 * 1.618);
        @include border-radius($border-radius * 4);
        @include gradient-directional($color-darken, lighten($color-darken, 1), -10deg);
        @include custom-box-shadow($darken, 2px, 0.02);
        margin-bottom: $spacer * 2 * 1.618;
        z-index: 2;
    }

    &--padding-sm &__content {
        padding: $spacer;
    }

    &--contains {
        @include make-container();
        @include make-container-max-widths();
    }
}
</style>
