<template lang="html">
    <svg
        :width="size"
        :height="size"
        class="ui-library-hover"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
        <path
            ref="path"
            class="ui-library-hover__path"
            d="M61.57,26.67V37.32H38V63H26V37.32H2.43V26.67H26V1H38V26.67Z"/>
    </svg>
</template>

<script>
import { TweenMax } from 'gsap'

export default {
    name: 'LibraryHover',
    props: {
        size: {
            type: String,
            default: '32px'
        },
    },
    data: function() {
        return {
            master: null,
            status: false,
        }
    },
    methods: {
        init: function() {
            if (!this.master) {
                this.master = new TimelineMax({
                    paused: true,
                    yoyo: true,
                })

                this.master.fromTo(this.$refs.path, .6, {
                    fill: '#000000'
                }, {
                    fill: '#ffffff'
                })

                this.master.progress(1).progress(0)
                this.$nextTick(() => {
                    this.$emit('ready')
                })
            }
        },
        play: function() {
            if (this.master) {
                this.master.play()
            }
        },
        reverse: function() {
            if (this.master) {
                this.master.reverse()
            }
        }
    },
    mounted: function() {
        this.init()
    },
    beforeDestroy: function() {
        if (this.master) {
            this.master.kill()
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-library-hover {
    &__path {
        fill: $white;
    }
}
</style>
