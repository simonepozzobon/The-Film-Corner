<template>
    <div id="video-player">
        <div id="loader" ref="loader">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <video-player
            class="video-player-box"
            ref="videoPlayer"
            :options="playerOptions"
            :playsinline="true">
        </video-player>
    </div>
</template>
<script>
import {TimelineMax} from 'gsap'
import 'video.js/dist/video-js.css'
import {videoPlayer} from 'vue-video-player'

export default {
    name: 'VideoPreview',
    data: function() {
        return {
            master: null,
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
                console.log('show loader')
                this.showLoader()
            } else {
                console.log('hide loader')
                this.hideLoader()
            }
        }
    },
    methods: {
        init: function() {
            let loader = this.$refs.loader,
            player = this.$refs.videoPlayer.$el

            this.master = new TimelineMax({
                paused: true,
                reversed: true,
            })

            this.master.fromTo(loader, .6, {
                autoAlpha: 1,
                display: 'block',
            }, {
                autoAlpha: 0,
                display: 'none'
            })

            this.master.fromTo(player, .6, {
                autoAlpha: 0,
                display: 'none'
            }, {
                autoAlpha: 1,
                display: 'block',
            })

            this.master.progress(1).progress(0)
            this.master.play()
            console.log('player loaded')
        },
        showLoader: function() {
            this.master.pause().progress(0).play()
        },
        hideLoader: function() {
            this.master.pause().progress(1).reverse()
        }
    },
    mounted: function() {
        this.init()
    }

}
</script>
<style lang="scss" scoped>
@import '~styles/shared';

.video-player-box {
    // display: none;
    // opacity: 0;
}
</style>
