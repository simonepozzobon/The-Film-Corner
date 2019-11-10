<template>
<svg
    ref="icon"
    width="16"
    xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 0 22.29 22.29"
>
    <defs>
        <clipPath id="a">
            <rect
                x="4.76"
                y="0.5"
                width="12.77"
                height="21.29"
                style="fill: none"
            />
        </clipPath>
    </defs>
    <g style="clip-path: url(#a)">
        <polyline
            points="5.82 20.73 15.41 11.14 5.82 1.56"
            style="fill: none;stroke: #1d1d1b;stroke-width: 3px"
        />
    </g>
</svg>
</template>

<script>
import {
    TimelineMax
}
from 'gsap/all'
export default {
    name: 'UiAccordionArrow',
    props: {
        isOpen: {
            type: Boolean,
            default: false,
        }
    },
    data: function () {
        return {
            master: null,
        }
    },
    watch: {
        'isOpen': function (value) {
            if (value) {
                this.play()
            }
            else {
                this.reverse()
            }
        }
    },
    methods: {
        init: function () {
            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(this.$refs.icon, .6, {
                rotation: 0,
            }, {
                rotation: 90,
            }, 0)

            this.master.progress(1).progress(0)
        },
        play: function () {
            if (this.master) {
                this.master.play()
            }
        },
        reverse: function () {
            if (this.master) {
                this.master.reverse()
            }
        }
    },
    mounted: function () {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
