<template lang="html">
    <div class="ui-app-audio-preview">
        <ui-title
            title="Preview"
            color="white"
            :has-padding="false"
            ref="title"/>

        <div class="ui-app-audio-preview__loader" ref="loader">
            <div class="spinner-border text-green" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div
            ref="player"
            class="ui-app-audio-preview__player"></div>

        <ui-app-video-controls
            @play="play"
            @pause="pause"
            @stop="stop"
            @backward="backward"
            @forward="forward"/>
    </div>
</template>

<script>
import UiAppVideoControls from './UiAppVideoControls.vue'
import { UiTitle } from '../ui'
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'
import SizeUtility from '../Sizes'

import WaveSurfer from 'wavesurfer.js'
import RegionsPlugin from 'wavesurfer.js/src/plugin/regions.js'

export default {
    name: 'UiAppAudioPreview',
    components: {
        UiAppVideoControls,
        UiTitle,
        videoPlayer,
    },
    props: {
        src: {
            type: String,
            default: '/video/empty-session.mp4',
        },
    },
    data: function() {
        return {
            master: null,
            player: null,
        }
    },
    watch: {
        'src': function(src) {
            if (this.player) {
                this.changeSrc(src)
            } else {
                this.init()
            }
        }
    },
    methods: {
        init: function() {
            this.player = WaveSurfer.create({
                container: this.$refs.player,
                plugins: [ RegionsPlugin.create({}) ]
            })
            this.changeSrc(this.src)
            // console.log(this.src);
        },
        changeSrc: function(src = null) {
            return new Promise((resolve, reject) => {
                if (src) {
                    this.player.load(src)
                    let duration = this.player.getDuration()
                    this.player.addRegion({
                        start: 0,
                        end: duration,
                        loop: true,
                        color: 'hsla(100, 100%, 30%, 0.1)'
                    })
                    this.$nextTick(resolve)
                } else {
                    reject()
                }
            })
        },
        play: function() {
            this.player.play()
        },
        pause: function() {
            this.player.pause()
        },
        stop: function() {
            if (this.player.isPlaying()) {
                this.player.pause()
                this.player.seekTo(0)
            }
        },
        backward: function() {
            this.player.skipBackward(5)
        },
        forward: function() {
            this.player.skipForward(5)
        },
    },
    mounted: function() {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-audio-preview {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    @include border-left-radius(24px);
    padding-left: $app-padding-x;
    padding-right: $app-padding-x;
    padding-top: $app-padding-x;
    padding-bottom: 0;
    overflow: hidden;
    z-index: 1;

    &__loader {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 0;
        width: 100%;
        visibility: hidden;
        opacity: 0;
    }

    &__player {
        position: relative;
    }
}
</style>
