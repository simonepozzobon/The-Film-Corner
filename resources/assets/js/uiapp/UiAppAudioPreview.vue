<template>
<div class="ui-app-audio-preview">
    <ui-title
        title="Preview"
        color="white"
        :has-padding="false"
        ref="title"
    />

    <div
        class="ui-app-audio-preview__loader"
        ref="loader"
    >
        <div
            class="spinner-border"
            :class="loaderColorClass"
            role="status"
        >
            <span class="sr-only">
                Loading...
            </span>
        </div>
    </div>

    <div
        ref="player"
        class="ui-app-audio-preview__player"
    ></div>

    <ui-app-video-controls
        class="ui-app-audio-preview__controls"
        @play="play"
        @pause="pause"
        @stop="stop"
        @backward="backward"
        @forward="forward"
    />
</div>
</template>

<script>
import UiAppVideoControls from './UiAppVideoControls.vue'
import {
    UiTitle
} from '../ui'
import 'video.js/dist/video-js.css'
import {
    videoPlayer
} from 'vue-video-player'
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
        noRegion: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            master: null,
            player: null,
        }
    },
    watch: {
        'src': function (src) {
            if (this.player) {
                this.changeSrc(src)
            } else {
                this.init()
            }
        }
    },
    computed: {
        loaderColorClass: function () {
            return 'text-' + this.color
        }
    },
    methods: {
        init: function () {
            if (this.noRegion) {
                this.player = WaveSurfer.create({
                    container: this.$refs.player,
                })
            } else {
                this.player = WaveSurfer.create({
                    container: this.$refs.player,
                    plugins: [RegionsPlugin.create({})]
                })
            }
            this.player.on('ready', () => this.$emit('ready'))
            if (this.src) {
                this.changeSrc(this.src)
            }
        },
        changeSrc: function (src = null) {
            return new Promise((resolve, reject) => {
                if (src) {
                    this.player.load(src)
                    if (!this.noRegion) {
                        let duration = this.player.getDuration()
                        this.player.addRegion({
                            start: 0,
                            end: duration,
                            loop: true,
                            color: 'hsla(100, 100%, 30%, 0.1)'
                        })
                    }
                    resolve()
                } else {
                    reject()
                }
            })
        },
        play: function () {
            this.player.play()
        },
        pause: function () {
            this.player.pause()
        },
        stop: function () {
            if (this.player.isPlaying()) {
                this.player.pause()
                this.player.seekTo(0)
            }
        },
        backward: function () {
            this.player.skipBackward(5)
        },
        forward: function () {
            this.player.skipForward(5)
        },
    },
    mounted: function () {}
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-audio-preview {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    @include border-left-radius(24px);
    padding: $app-padding-x $app-padding-x 0;
    overflow: hidden;
    z-index: 1;
    display: flex;
    flex-direction: column;

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
        margin-top: auto;
        margin-bottom: auto;
        position: relative;
    }

    &__controls {
        margin-top: auto;
    }
}
</style>
