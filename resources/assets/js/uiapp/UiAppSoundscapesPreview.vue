<template>
    <div class="ui-app-soundscapes-preview">
        <ui-title
            title="Preview"
            color="white"
            :has-padding="false"
            ref="title"/>

        <img
            :src="image"
            ref="image"
            class="ui-app-soundscapes-preview__image" />

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

export default {
    name: 'UiAppSoundscapesPreview',
    components: {
        UiAppVideoControls,
        UiTitle,
    },
    props: {
        src: {
            type: String,
            default: '/img/test-app/1.png',
        },
        color: {
            type: String,
            default: 'green'
        },
        players: {
            type: Array,
            default: function() {}
        }
    },
    data: function() {
        return {
            master: null,
            image: null,
            ready: {
                component: false,
                image: false,
            }
        }
    },
    watch: {
        src: function(src) {
            this.loadSrc()
        }
    },
    computed: {
    },
    methods: {
        changeSrc: function(src = null) {
            return new Promise((resolve, reject) => {
                resolve()
            })
        },
        play: function() {
            for (let i = 0; i < this.players.length; i++) {
                this.players[i].player.play()
            }
        },
        pause: function() {
            for (let i = 0; i < this.players.length; i++) {
                this.players[i].player.pause()
            }
        },
        stop: function() {
            for (let i = 0; i < this.players.length; i++) {
                if (this.players[i].player.isPlaying()) {
                    this.players[i].player.pause()
                    this.players[i].player.seekTo(0);
                }
            }
        },
        backward: function() {
            for (let i = 0; i < this.players.length; i++) {
                this.players[i].player.skipBackward(5)
            }
        },
        forward: function() {
            for (let i = 0; i < this.players.length; i++) {
                this.players[i].player.skipForward(5)
            }
        },
        loadSrc: function() {
            let img = new Image()
            img.addEventListener('load', () => {
                this.image = this.src
                this.$nextTick(() => {
                    this.ready.image = true
                })
            })

            img.src = this.src
        },
        checkReady: function(readyCounter) {
            let ready = true
            for (let key in readyCounter) {
                if (readyCounter.hasOwnProperty(key) && !readyCounter[key]) {
                    ready = false
                }
            }

            if (ready) {
                this.$emit('ready')
            }
        },
    },
    created: function() {
        this.$watch('ready', this.checkReady, { deep: true })
    },
    mounted: function() {
        this.loadSrc()
        this.$nextTick(() => {
            this.ready.component = true
        })
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-soundscapes-preview {
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

    &__image {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: auto;
    }
}
</style>
