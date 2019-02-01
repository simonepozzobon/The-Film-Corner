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
            :playsinline="true"
            @timeupdate="onPlayerTimeUpdate($event)">
        </video-player>
    </div>
</template>
<script>
import {TimelineMax} from 'gsap'
import 'video.js/dist/video-js.css'
import {videoPlayer} from 'vue-video-player'

export default {
    name: 'VideoPreview',
    props: {
        video_src: {
            type: String,
            default: '',
        }
    },
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
                    src: this.video_src,
                }],
                // poster: '/video/empty-session.png',
            }
        }
    },
    methods: {
        onPlayerTimeUpdate: function(player) {
            let time = player.currentTime()
            this.$root.$emit('player-time-update', time)
        },
        init: function() {
            let loader = this.$refs.loader,
            player = this.$refs.videoPlayer.$el,
            height = player.offsetHeight

            loader.style.height = height + 'px'

            this.master = new TimelineMax({
                paused: true,
                reversed: true,
            })

            this.master.fromTo(loader, .6, {
                autoAlpha: 1,
                display: 'flex',
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

            this.master.play()
            console.log('player loaded')
        },
        showLoader: function() {
            console.log('show loader')
            let loader = this.$refs.loader,
            player = this.$refs.videoPlayer.$el,
            height = player.offsetHeight

            loader.style.height = height + 'px'

            let master = new TimelineMax({
                paused: true,
                reversed: true,
            })

            master.fromTo(player, .6, {
                autoAlpha: 1,
                display: 'block'
            }, {
                autoAlpha: 0,
                display: 'none',
            })

            master.fromTo(loader, .6, {
                autoAlpha: 0,
                display: 'none'
            }, {
                autoAlpha: 1,
                display: 'flex',
            })

            master.play()
        },
        hideLoader: function() {
            console.log('hide loader')
            let loader = this.$refs.loader,
            player = this.$refs.videoPlayer.$el,
            height = player.offsetHeight

            loader.style.height = height + 'px'

            let master = new TimelineMax({
                paused: true,
                reversed: true,
            })

            master.fromTo(loader, .6, {
                autoAlpha: 1,
                display: 'flex',
            }, {
                autoAlpha: 0,
                display: 'none'
            })

            master.fromTo(player, .6, {
                autoAlpha: 0,
                display: 'none',
            }, {
                autoAlpha: 1,
                display: 'block'
            })

            master.play()
        },
        changeSrc: function(src = null) {
            return new Promise(resolve => {
                this.playerOptions.sources[0].src = src
                this.playerOptions.poster = ''
                resolve()
            })
        },
        play: function() {
            this.$refs.videoPlayer.player.play()
        },
        pause: function() {
            this.$refs.videoPlayer.player.pause()
        },
        stop: function() {
            this.$refs.videoPlayer.player.pause()
            this.$refs.videoPlayer.player.currentTime(0)
        },
        backward: function() {
            this.$refs.videoPlayer.player.pause()
            let position = this.$refs.videoPlayer.player.currentTime()
            if (position >= 5) {
                this.$refs.videoPlayer.player.currentTime(position - 5)
            } else {
                this.$refs.videoPlayer.player.currentTime(0)
            }
        },
        forward: function() {
            this.$refs.videoPlayer.player.pause()
            let position = this.$refs.videoPlayer.player.currentTime()
            console.log('da terminare')
        },
    },
    mounted: function() {
        this.init()
        this.$root.video_src = this.video_src
    }

}
</script>
<style lang="scss" scoped>
@import '~styles/shared';

#video-player {
    #loader {
        justify-content: center;
        align-items: center;
    }
}
.video-player-box {
    // display: none;
    // opacity: 0;
}
</style>
