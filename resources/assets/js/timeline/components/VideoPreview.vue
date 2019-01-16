<template>
    <div id="video-player">
        <div id="loader" ref="loader">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- <video-player
            class="video-player-box"
            ref="videoPlayer"
            :options="playerOptions"
            :playsinline="true">
        </video-player> -->
    </div>
</template>
<script>
import 'video.js/dist/video-js.css'
import {videoPlayer} from 'vue-video-player'

export default {
    name: 'VideoPreview',
    data: function() {
        return {
            size: {
                w: 0,
                h: 0,
            },
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: '/img/test-app/oceans.mp4'
                }],
                poster: '/img/test-app/1.png',
            }
        }
    },
    watch: {
        '$root.showLoader': function(loader) {
            if (loader) {
                console.log()
            }
        }
    },
    mounted: function() {
    }

}
</script>
<style lang="scss" scoped>
</style>
