<template>
    <div class="net-preview">
        <div class="net-preview__content">
            <img
                v-if="type == 'image'"
                :src="src"
                :alt="title"
                class="net-preview__image" />

            <video-player
                ref="player"
                v-else-if="type == 'video'"
                class="video-player-box net-preview__player"
                :options="playerOptions"
                :playsinline="true"/>
        </div>
    </div>
</template>

<script>
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'

export default {
    name: 'NetPreview',
    components: {
        videoPlayer,
    },
    props: {
        src: {
            type: String,
            default: '/img/test-app/4.png',
        },
        type: {
            type: String,
            default: 'image',
        },
        title: {
            type: String,
            default: 'Titolo',
        },
        thumb: {
            type: String,
            default: null,
        },
    },
    data: function() {
        return {
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: '/video/empty-session.mp4'
                }],
                poster: '/video/empty-session.png',
            }
        }
    },
    computed: {
        player: function() {
            return this.$refs.player.player
        },
    },
    methods: {
        setSrc: function() {
            if (this.thumb)
                this.playerOptions.poster = this.thumb

            this.playerOptions.sources[0].src = this.src
        },
    },
    mounted: function() {
        this.$nextTick(() => {
            if (this.type == 'video' && this.src)
                this.setSrc()
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.net-preview {
    margin-top: $spacer * 1.618;
    margin-left: $spacer;
    margin-right: $spacer;

    &__content {
        overflow: hidden;
        @include border-radius(16px);
    }

    &__image {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: auto;
    }
}
</style>
