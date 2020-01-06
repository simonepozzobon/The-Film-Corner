<template>
<div class="a-video-player">
    <transition name="fade">
        <div
            class="a-video-player__loader a-spinner"
            v-if="!posterSrc"
        >
            <div
                class="spinner-border a-spinner__el"
                role="status"
            >
            </div>
        </div>
    </transition>
    <transition name="fade">
        <div
            class="a-video-player__img a-player-poster"
            v-if="posterSrc"
            @click.prevent.stop="showPreview"
        >
            <img :src="posterSrc" />
            <div class="a-player-poster__overlay"></div>
        </div>
    </transition>

    <ui-modal
        ref="modal"
        title="Anteprima della clip"
        :hide-header="true"
        :hide-footer="true"
        @hidden="stopPlayer"
    >
        <div class="player">
            <video
                ref="player"
                class="video-js"
            ></video>
        </div>
    </ui-modal>
</div>
</template>

<script>
import videojs from 'video.js'
import 'video.js/dist/video-js.css'
import UiModal from '../adminui/UiModal.vue'

export default {
    name: 'SimpleVideoPlayer',
    components: {
        UiModal,
    },
    props: {
        src: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            posterSrc: null,
            player: null,
            options: {
                aspectRatio: '16:9',
                controls: true,
                preload: 'auto',
                width: 480,
                height: 270,
                sources: [{
                    src: this.src ? this.src : '/video/empty-session.mp4',
                    type: 'video/mp4',
                }]
            },
        }
    },
    methods: {
        initPlayer: function () {
            this.player = videojs(this.$refs.player, this.options)
            this.player.on('loadeddata', () => {
                this.getThumbnail()
            })
        },
        getThumbnail: function () {
            let player = this.player.tech({
                IWillNotUseThisInPlugins: true
            }).el()

            let canvas = document.createElement('canvas')
            canvas.height = 270
            canvas.width = 480

            let height = this.$refs.player.offsetWidth
            let width = this.$refs.player.offsetWidth

            let ctx = canvas.getContext('2d')
            ctx.drawImage(player, 0, 0)

            this.posterSrc = canvas.toDataURL()

        },
        stopPlayer: function () {
            this.player.pause()
            this.player.currentTime(0)
        },
        showPreview: function () {
            this.$refs.modal.show()
        },
    },
    mounted: function () {
        this.initPlayer()
    },
    beforeDestroy: function () {
        if (this.player) {
            this.player.dispose()
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.a-video-player {
    position: relative;
    min-width: 96px;
    min-height: 54px;
    display: flex;
    align-items: center;
}

.a-spinner {
    &__el {
        color: $gray-400;
    }
}

.a-player-poster {
    @include border-radius($border-radius * 2);
    overflow: hidden;
    max-width: 96px;
    position: relative;
    cursor: pointer;

    img {
        width: 100%;
    }

    &__overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba($gray-200, .3);
        z-index: 1;
        opacity: 0;
        transition: $transition-base;
    }

    &:hover &__overlay {
        opacity: 1;
        transition: $transition-base;
    }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
    position: absolute;
    left: 0;
    top: 0;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
