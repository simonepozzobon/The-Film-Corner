<template>
<div
    class="fullscreen-message"
    ref="panel"
>
    <ui-title
        :title="this.$root.fullMessage"
        color="white"
    />
</div>
</template>

<script>
import {
    UiTitle
}
from '../ui'

import {
    TweenMax,
    Power4,
}
from 'gsap/all'

const plugins = [
    Power4,
]

export default {
    name: 'FullScreenMessage',
    components: {
        UiTitle
    },
    methods: {
        init: function () {
            let el = this.$refs.panel
            let master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            master.fromTo(el, .5, {
                scaleX: 0,
            }, {
                scaleX: 1,
                ease: Sine.easeOut,
            }, 0)

            master.fromTo(el, .5, {
                scaleY: .8,
                autoAlpha: 0,
            }, {
                scaleY: 1,
                autoAlpha: 1,
                ease: Power4.easeIn,
            }, .1)

            master.fromTo(el, .5, {
                scaleY: 1,
                autoAlpha: 1,
            }, {
                scaleY: .8,
                autoAlpha: 0,
                ease: Power4.easeOut,
            }, 2.9)

            master.fromTo(el, .5, {
                scaleX: 1,
            }, {
                scaleX: 0,
                ease: Sine.easeIn,
            }, 3)


            master.progress(1).progress(0)

            this.$root.fullMessageMaster = master
        },
    },
    mounted: function () {
        this.init()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.fullscreen-message {
    position: fixed;
    top: 154px;
    width: 100%;
    height: calc(100vh - 154px);
    z-index: $zindex-fixed - 3;
    display: flex;
    align-items: center;
    justify-content: center;
    @include gradient-radial(rgba($gray-700, .95), rgba($gray-800, .95));
}
</style>
