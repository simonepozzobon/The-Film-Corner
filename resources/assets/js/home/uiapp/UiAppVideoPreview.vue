<template lang="html">
    <div class="ui-app-video-preview">
        <ui-title
            title="Preview"
            color="white"
            :has-padding="false"
            ref="title"/>

        <video-player
            class="video-player-box"
            ref="videoPlayer"
            :options="playerOptions"
            :playsinline="true"
            @timeupdate="onPlayerTimeUpdate($event)">
        </video-player>

        <ui-app-video-controls />
    </div>
</template>

<script>
import UiAppVideoControls from './UiAppVideoControls.vue'
import { UiTitle } from '../ui'
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'

export default {
    name: 'UiAppVideoPreview',
    components: {
        UiAppVideoControls,
        UiTitle,
        videoPlayer,
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
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-video-preview {
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

    &__canvas {
        width: 100%;
        height: 100%;
    }
}
</style>
