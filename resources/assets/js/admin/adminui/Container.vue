<template>
<div
    class="admin-container"
    :class="paddingClass"
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
        paddingClass: function () {
            if (this.padding) {
                return 'admin-container--padding-' + this.padding
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

            this.master.set(container, {
                overflow: 'hidden'
            })

            this.master.fromTo(container, .6, {
                height: 0,
                ease: Power4.easeInOut,
            }, {
                height: 'auto',
                ease: Power4.easeInOut,
            })

            this.master.progress(1).progress(0)

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
        if (this.hasAnimations == true) {
            this.initAnim()
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-container {
    &__content {
        background-color: $gray-100;
        padding: $spacer * 2;
        @include border-radius($border-radius);
        @include custom-box-shadow(lighten($black, 25));
        margin-bottom: $spacer * 1.618;
        z-index: 2;
    }

    &--padding-sm &__content {
        padding: $spacer;
    }
}
</style>
