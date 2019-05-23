<template lang="html">
    <div class="menu-item" ref="item">
        <a
            :href="url"
            :target="target"
            ref="text"
            :class="uuid + ' menu-item__link'"
            @mouseenter="hoverAnim"
            @mouseleave="hoverAnimLeave"
            @click="mainClick">
            {{ title }}
        </a>
        <div class="menu-item__underline" ref="underline"></div>
    </div>
</template>

<script>
import { TweenMax } from 'gsap'
import CSSPlugin from 'gsap/CSSPlugin'

export default {
    name: 'UiMenuItem',
    props: {
        title: {
            type: String,
            default: 'Titolo'
        },
        target: {
            type: String,
            default: '_self'
        },
        url: {
            type: String,
            default: '#'
        }
    },
    data: function() {
        return {
            master: null,
            status: false,
            duration: .4,
            scale: 2,
            ease: Back.easeIn.config(1.2),
            back: Back.easeOut.config(1.2),
        }
    },
    computed: {
        uuid: function() {
            // https://gist.github.com/6174/6062387
            return [...Array(10)].map(i=>(~~(Math.random()*36)).toString(36)).join('')
        },
    },
    methods: {
        init: function() {
            let duration = this.duration
            let scale = this.scale
            let invscale = 1 / scale
            let back = this.back
            let base = this.ease

            let el = this.$refs.underline
            let text = this.$refs.text

            let width = el.getBoundingClientRect().width

            this.master = new TimelineMax({
                paused: true,
                reversed: true,
                yoyo: true,
            })

            this.master.fromTo(el, duration, {
                width: 0,
                ease: ExpoScaleEase.config(scale, 1, back),
            }, {
                width: width,
                ease: ExpoScaleEase.config(scale, 1, back),
            }, .1)

            this.master.fromTo(text, duration * 0.33, {
                scale: 1,
                ease: ExpoScaleEase.config(scale, 1, base),
            }, {
                scale: 1.1,
                ease: ExpoScaleEase.config(scale, 1, base),
            }, 0)

            this.master.progress(1).progress(0)

            this.master.eventCallback('onComplete', () => {
                this.status = true
            })

            this.master.eventCallback('onReverseComplete', () => {
                this.status = false
            })
        },
        hoverAnim: function() {
            if (!this.status && this.master) {
                return this.master.pause().play()
            }
        },
        hoverAnimLeave: function() {
            if (this.master) {
                return this.master.pause().reverse()
            }
        },
        mainClick: function(event) {
            if (this.target == '_self') {
                event.preventDefault()
            }

            this.$emit('main-click', this.url, this.target)
        }
    },
    mounted: function() {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.menu-item {
    position: relative;
    padding-bottom: $spacer;
    padding-top: $spacer;

    &__link {
        position: relative;
        display: block;
        color: $gray-700;
        font-weight: $font-weight-bold;
        text-transform: uppercase;
        transition: $transition-base;

        &:hover, &:focus {
            text-decoration: none;
            transition: $transition-base;
        }
    }

    &__underline {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: $red;
        bottom: 0px;
        left: 0;
    }
}
</style>
