<template>
<div
    class="admin-container"
    :class="[
        paddingClass,
        containsClass,
        topMarginClass
      ]"
    ref="container"
>
    <div class="admin-container__content">
        <slot></slot>
    </div>
</div>
</template>

<script>
import {
    TweenMax,
    TimelineMax,
    Power4,
    gsap
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
        topMargin: {
            type: Boolean,
            default: true,
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
        },
        topMarginClass: function () {
            if (this.topMargin == false) {
                return 'admin-container--no-top'
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

            master.fromTo(container, .6, {
                // height: '1px',
                maxHeight: 0,
                autoAlpha: 0,
                ease: 'power4.inOut',
            }, {
                autoAlpha: 1,
                // height: 'auto',
                maxHeight: '100%',
                ease: 'power4.inOut',
                immediateRender: false,
            }, 'start+=0')

            master.to(container, .1, {
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
        position: relative;
        padding: ($spacer * 2) ($spacer * 2 * 1.618) ($spacer * 1.618) ($spacer * 2 * 1.618);
        margin-top: $spacer * 2 * 1.618;
        @include border-radius($border-radius * 4);
        @include gradient-directional($color-darken, lighten($color-darken, 1), -10deg);
        @include custom-box-shadow($darken, 2px, 0.02);
        z-index: 2;
        transition: $transition-base;
    }

    &__content:before {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        content: '';
        z-index: -1;
        @include border-radius($border-radius * 4);
        @include gradient-directional(darken($color-darken, 70), darken($color-darken, 69), -10deg);
        opacity: 0;
    }

    &--padding-sm &__content {
        padding: $spacer;
    }

    &--padding-no &__content {
        padding: ($spacer * 2) ($spacer * 2) ($spacer * 1.618) ($spacer * 2);
    }

    &--no-top &__content {
        margin-top: 0;
    }

    &--contains {
        @include make-container();
        @include make-container-max-widths();
    }

    &--contains &--padding-no {
        padding: 0;
    }

    &--sticky &__content:before {
        opacity: 1;
        transition: $transition-base;
    }
}
</style>
