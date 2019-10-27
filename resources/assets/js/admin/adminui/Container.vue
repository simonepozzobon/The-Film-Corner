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
    TimelineMax,
    Power4,
}
from 'gsap'
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
    },
    data: function () {
        return {
            master: null
        }
    },
    watch: {
        state: function () {
            this.setState()
        },
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
            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(container, .6, {
                height: 0,
                overflow: 'hidden',
                autoAlpha: 0,
                ease: Power4.easeInOut,
            }, {
                autoAlpha: 1,
                height: 'auto',
                overflow: 'auto',
                ease: Power4.easeInOut,
                onComplete: () => {
                    TweenMax.set(container, {
                        clearProps: 'overflow'
                    })
                }
            })

            if (this.state == false) {
                this.$nextTick(() => {
                    this.hidePanel()
                })
            }
            else {
                this.$nextTick(() => {
                    this.showPanel()
                })
            }
        },
        setState: function () {
            if (this.state == true) {
                this.showPanel()
            }
            else {
                this.hidePanel()
            }
        },
        showPanel: function () {
            if (this.master) {
                this.$ebus.$emit('add-anim', this.master, true, this.uuid, 'container-apri')
            }
        },
        hidePanel: function () {
            if (this.master) {
                this.$ebus.$emit('add-anim', this.master, false, this.uuid, 'container-chiudi')
            }
        },
    },
    mounted: function () {
        if (this.hasAnimations == true) {
            this.$nextTick(() => {
                this.initAnim()
            })
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
