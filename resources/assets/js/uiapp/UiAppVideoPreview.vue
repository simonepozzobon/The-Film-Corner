<template>
<div class="ua-video-preview">
    <ui-title
        title="Preview"
        color="white"
        :has-padding="false"
        ref="title"
    />

    <div
        class="ua-video-preview__loader"
        ref="loader"
    >
        <div
            class="spinner-border"
            :class="loaderColorClass"
            role="status"
        >
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <video-player
        class="video-player-box ua-video-preview__player"
        ref="player"
        :options="playerOptions"
        :playsinline="true"
        @timeupdate="onPlayerTimeUpdate($event)"
        @ready="ready"
    />

    <ui-app-video-controls
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
}
from '../ui'
import 'video.js/dist/video-js.css'
import {
    videoPlayer
}
from 'vue-video-player'
import SizeUtility from '../Sizes'
export default {
    name: 'UiAppVideoPreview',
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
        color: {
            type: String,
            default: 'green'
        }
    },
    data: function () {
        return {
            master: null,
            loaderVisible: false,
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: '/video/empty-session.mp4'
                }],
                poster: '/video/empty-session.png',
            },
            playerHeight: 0,
        }
    },
    watch: {
        'src': function (src) {
            if (src) {
                this.playerOptions.sources[0]['src'] = src
                this.playerOptions.poster = ''
            }
        }
    },
    computed: {
        player: function () {
            return this.$refs.player.player
        },
        loaderColorClass: function () {
            return 'text-' + this.color
        }
    },
    methods: {
        changeSrc: function (src = null) {
            return new Promise((resolve, reject) => {
                if (src) {
                    this.playerOptions.sources[0]['src'] = src
                    this.playerOptions.poster = ''
                    this.$nextTick(resolve)
                }
                else {
                    reject()
                }
            })
        },
        onPlayerTimeUpdate: function (player) {
            let time = this.player.currentTime()
            this.$emit('on-update-player', time)
        },
        play: function () {
            this.player.play()
        },
        pause: function () {
            this.player.pause()
        },
        stop: function () {
            this.player.pause()
            this.player.currentTime(0)
        },
        backward: function () {
            this.player.pause()
            let position = this.player.currentTime()
            if (position >= 5) {
                this.player.currentTime(position - 5)
            }
            else {
                this.player.currentTime(0)
            }
        },
        forward: function () {
            this.player.pause()
            let position = this.player.currentTime()
        },
        showLoader: function () {
            if (!this.loaderVisible) {
                let el = this.$refs.player.$el
                let loader = this.$refs.loader
                if (el && loader) {
                    this.loaderVisible = true

                    let size = SizeUtility.get(el)
                    this.playerHeight = Math.round(size.h)

                    TweenMax.set([el, loader], {
                        clearProps: "all"
                    })

                    let master = new TimelineMax({
                        paused: true,
                        autoRemoveChildren: true
                    })
                    master.fromTo(el, .6, {
                        transformOrigin: '50% 100%',
                        height: size.h,
                        autoAlpha: 1,
                    }, {
                        transformOrigin: '50% 100%',
                        height: 0,
                        autoAlpha: 0,
                    }, 0)
                    master.fromTo(loader, .3, {
                        height: 0,
                        autoAlpha: 0,
                    }, {
                        height: size.h,
                        autoAlpha: 1,
                    }, 0)
                    master.progress(1).progress(0)
                    master.eventCallback('onComplete', () => {
                        this.$nextTick(() => {
                            master.kill()
                        })
                    })
                    master.play()
                }
            }
        },
        hideLoader: function () {
            return new Promise(resolve => {
                if (this.loaderVisible) {
                    let el = this.$refs.player.$el
                    let loader = this.$refs.loader
                    if (el && loader) {
                        let size = SizeUtility.get(loader)
                        let originalHeight = this.playerHeight
                        // console.log('player', size.h, this.playerHeight);

                        let master = new TimelineMax({
                            paused: true
                        })

                        master.fromTo(el, .3, {
                            transformOrigin: '50% 0%',
                            height: 0,
                            autoAlpha: 0,
                        }, {
                            transformOrigin: '50% 0%',
                            height: originalHeight,
                            autoAlpha: 1,
                        }, 0)

                        master.fromTo(loader, .3, {
                            height: originalHeight,
                            autoAlpha: 1,
                        }, {
                            height: 0,
                            autoAlpha: 0,
                        }, 0)

                        master.progress(1).progress(0)
                        master.eventCallback('onComplete', () => {
                            this.loaderVisible = false
                            this.$nextTick(() => {
                                master.kill()
                                resolve()
                            })
                        })
                        master.play()
                    }
                }
                else {
                    resolve()
                }
            })
        },
        ready: function () {
            if (this.loaderVisible) {
                // console.log('triggered');
                this.hideLoader().then(() => {
                    this.$emit('ready')
                })
            }
            else {
                this.$emit('ready')
            }
        }
    },
    mounted: function () {}
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-video-preview {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    @include border-left-radius(24px);
    padding: $app-padding-x $app-padding-x 0;
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
