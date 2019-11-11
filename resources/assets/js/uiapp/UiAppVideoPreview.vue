<template>
<div class="ua-video-preview">
    <div class="ua-video-preview__title">
        <ui-title
            title="Preview"
            color="white"
            :has-padding="false"
            ref="title"
        />
    </div>

    <div class="ua-video-preview__container">
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

        <div
            class="ua-video-preview__player"
            ref="playerContainer"
        >
            <video-player
                class="video-player-box"
                ref="player"
                :options="playerOptions"
                :playsinline="true"
                @timeupdate="onPlayerTimeUpdate($event)"
                @ready="ready"
            />
        </div>

        <ui-app-video-controls
            class="ua-video-preview__controls"
            @play="play"
            @pause="pause"
            @stop="stop"
            @backward="backward"
            @forward="forward"
            @update-size="setControlsHeight"
        />
    </div>
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

import {
    TimelineMax,
    TweenMax,
}
from 'gsap/all'

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
            controlsHeight: 0,
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
                let el = this.$refs.playerContainer
                let loader = this.$refs.loader
                if (el && loader) {
                    this.loaderVisible = true

                    TweenMax.set([el, loader], {
                        clearProps: "all"
                    })

                    let master = new TimelineMax({
                        paused: true,
                    })

                    master.addLabel('start', '+=0')

                    master.fromTo(el, .6, {
                        autoAlpha: 1,
                    }, {
                        autoAlpha: 0,
                        immediateRender: false,
                    }, 'start+=0.2')

                    master.fromTo(loader, .3, {
                        autoAlpha: 0,
                    }, {
                        autoAlpha: 1,
                        immediateRender: false,
                    }, 'start')

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
                    let el = this.$refs.playerContainer
                    let loader = this.$refs.loader
                    if (el && loader) {

                        let master = new TimelineMax({
                            paused: true
                        })

                        master.addLabel('start', '+=0')

                        master.fromTo(el, .3, {
                            autoAlpha: 0,
                        }, {
                            autoAlpha: 1,
                            immediateRender: false,
                        }, 'start+=0.2')

                        master.fromTo(loader, .3, {
                            autoAlpha: 1,
                        }, {
                            autoAlpha: 0,
                            immediateRender: false,
                        }, 'start')

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
                console.log('triggered');
                this.hideLoader().then(() => {
                    this.$emit('ready')
                })
            }
            else {
                this.$emit('ready')
            }
        },
        setControlsHeight: function (height) {
            // this.controlsHeight = height
            // this.$refs.playerContainer.style.bottom = `${0}px`
        },
    },
    mounted: function () {

    }
}
</script>
<style lang="scss">
@import '~styles/shared';
.ua-video-preview {
    &__controls {
        left: 0;
        right: 0;
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-video-preview {
    width: 100%;
    height: auto;
    background-color: $dark-gray;
    @include border-left-radius(24px);
    overflow: hidden;
    z-index: 1;
    display: flex;
    flex-direction: column;
    // position: relative;

    &__title {
        padding: $app-padding-x $app-padding-x 0;
    }

    &__container {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
    }

    &__player {
        padding: 0 $app-padding-x;
        max-width: 100%;
    }

    &__loader {
        background-color: rgba($dark-gray, .9);
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        width: 100%;
        height: 100%;
        visibility: hidden;
        opacity: 0;
        z-index: 2;

        .spinner-border {
            width: $spacer * 4;
            height: $spacer * 4;
            font-size: $font-size-base * 2;
        }
    }
    //
    // &__player {
    //     position: absolute;
    //     width: calc(100% - (#{$app-padding-x} * 2));
    //     height: 100%;
    //     top: 0;
    // }
}
</style>
