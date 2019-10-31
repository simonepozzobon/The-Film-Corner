<template>
<a
    href="#"
    class="ui-burger"
    ref="burger"
    @click="mainClick"
>
    <span
        class="ui-burger__line"
        ref="line1"
    ></span>
    <span
        class="ui-burger__line"
        ref="line2"
    ></span>
    <span
        class="ui-burger__line"
        ref="line3"
    ></span>
</a>
</template>

<script>
import {
    TweenMax,
    TimelineMax,
    Power4,
}
from 'gsap/all'

const plugins = [
    Power4,
]

export default {
    name: 'UiBurger',
    props: {
        size: {
            type: String,
            default: '32px'
        },
    },
    data: function () {
        return {
            master: null,
            hover: null,
            duration: .6,
            scale: 2,
            status: null,
            baseEase: Power4.easeInOut,
            hovering: false,
            initialized: false,
            isMobile: true,
        }
    },
    watch: {
        '$root.window.h': function (h) {
            // corregge bug su browser vecchi che modificano la viewport con la barra dell'indirizzo
            // let position = (16 * 100) / h
            // this.$refs.burger.style.top = position + 'vh'
            // this.$refs.burger.style.transform = 'translateZ(0)'
        }
    },
    methods: {
        init: function () {
            if (!this.master) {
                let duration = this.duration
                let scale = this.scale
                let invscale = 1 / scale
                let baseEase = this.baseEase

                let line1 = this.$refs.line1
                let line2 = this.$refs.line2
                let line3 = this.$refs.line3

                let burger = this.$refs.burger
                let rect = burger.getBoundingClientRect()
                let width = rect.width
                let height = rect.height
                let yMid = (height / 4)
                // console.log(yMid);

                // ExpoScaleEase.config(invscale, 1, ease_6)
                this.master = new TimelineMax({
                    paused: true,
                    reversed: true
                })

                this.master.fromTo(line1, duration, {
                    y: 0,
                    directionalRotation: {
                        rotation: '0_cw'
                    },
                    ease: ExpoScaleEase.config(invscale, 1, baseEase),
                }, {
                    y: yMid - 4,
                    directionalRotation: {
                        rotation: '45_cw'
                    },
                    ease: ExpoScaleEase.config(invscale, 1, baseEase),
                }, 0)

                this.master.fromTo(line2, duration, {
                    x: 0,
                    opacity: 1,
                    ease: ExpoScaleEase.config(scale, 1, baseEase),
                }, {
                    x: width,
                    opacity: 0,
                    ease: ExpoScaleEase.config(scale, 1, baseEase),
                }, 0)

                this.master.fromTo(line3, duration, {
                    y: 0,
                    directionalRotation: {
                        rotation: '0_ccw'
                    },
                    ease: ExpoScaleEase.config(invscale, 1, baseEase),
                }, {
                    y: -yMid + 4,
                    directionalRotation: {
                        rotation: '-45_ccw'
                    },
                    ease: ExpoScaleEase.config(invscale, 1, baseEase),
                }, 0)

                this.master.progress(1).progress(0)
                this.master.eventCallback('onStart', () => {
                    this.hovering = true
                })
                this.master.eventCallback('onReverseComplete', () => {
                    this.hovering = false
                })

                this.$emit('ready')

            }
            else {
                this.master.kill()
                this.master = null

                this.status = false
                this.hovering = false

                this.$nextTick(() => {
                    this.init()
                })
            }
        },
        toggle: function () {
            if (this.status) {
                this.status = false
                return this.close()
            }
            this.status = true
            return this.open()
        },
        open: function () {
            this.master.play()
        },
        close: function () {
            this.master.reverse()
        },
        mainClick: function (event) {
            event.preventDefault()
            this.$emit('main-click')
        },
    },
    mounted: function () {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-burger {
    position: absolute;
    top: $spacer;
    right: $spacer;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    overflow: hidden;
    z-index: $zindex-fixed;
    // transform: translateZ(0);

    // https://benfrain.com/easy-css-fix-fixed-positioning-android-2-2-2-3/
    // backface-visibility: hidden;

    width: $spacer * 4;
    height: $spacer * 4;
    // background-color: $brown;
    // @include box-shadows($gray-500);

    &__line {
        content: '';
        margin-top: $spacer / 4;
        margin-bottom: $spacer / 4;
        height: auto;
        width: $spacer * 2;
        border: 2px solid $black;
    }
}
</style>
