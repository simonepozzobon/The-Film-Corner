<template>
<ui-app-block
    ref="block"
    color="dark"
    align="center"
    :has-title="false"
>
    <div class="mixer-channels">
        <mixer-channel
            v-for="(player, i) in players"
            :key="i"
            :color="color"
            :idx="i"
            :src="player.obj"
            :vol="player.vol"
            @volume="volumeChanged"
            @remove-track="removeTrack"
        />
    </div>
</ui-app-block>
</template>

<script>
import UiAppBlock from './UiAppBlock.vue'
import MixerChannel from './sub/mixer/MixerChannel.vue'
import {
    TweenMax
}
from 'gsap'
require('gsap/ScrollToPlugin')

export default {
    name: 'UiAppMixer',
    components: {
        UiAppBlock,
        MixerChannel,
    },
    props: {
        color: {
            type: String,
            default: 'green'
        },
        players: [Array, Number]
    },
    methods: {
        loaded: function () {
            TweenMax.to(window, .2, {
                scrollTo: {
                    y: this.$refs.block.$el,
                    autoKill: false,
                }
            })
        },
        volumeChanged: function (volume, idx) {
            this.$emit('volume', volume, idx)
        },
        removeTrack: function (idx) {
            this.$emit('remove-track', idx)
        }
    },
    mounted: function () {
        // this.loaded()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.mixer-channels {
    display: flex;
    justify-content: space-around;
}
</style>
