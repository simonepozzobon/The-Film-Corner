<template>
<div
    class="ua-prop-player"
    :class="[
        topAlignClass,
        colorClass,
    ]"
>
    <div class="ua-prop-player__container">
        <div class="ua-prop-player__top">
            <div class="ua-prop-player__title">
                <ui-title
                    :title="lnTitle"
                    tag="h2"
                    font-size="h4"
                    :align="titleAlign"
                    :has-container="false"
                    :has-margin="false"
                    :has-padding="false"
                />
            </div>
            <div
                class="ua-prop-player__age"
                v-if="hasAge"
            >
                <ui-title
                    :title="age"
                    tag="h3"
                    font-size="h5"
                    :has-container="false"
                    :has-margin="false"
                    :has-padding="false"
                    :uppercase="false"
                    color="white"
                />
            </div>
        </div>
        <div class="ua-prop-player__center">
            <video-player
                class="video-player-box ua-video-preview__player"
                ref="player"
                :options="playerOptions"
                :playsinline="true"
                @ready="$emit('ready')"
            />
        </div>
        <div class="ua-prop-player__controls">
            <controls
                :color="color"
                @play="play"
                @pause="pause"
                @stop="stop"
                @backward="backward"
                @forward="forward"
            />
        </div>
    </div>
</div>
</template>

<script>
import Controls from './sub/propaganda/Controls.vue'

import {
    UiTitle,
}
from '../ui'

import {
    videoPlayer
}
from 'vue-video-player'

export default {
    name: 'UiAppPropagandaPlayer',
    components: {
        Controls,
        UiTitle,
        videoPlayer,
    },
    props: {
        title: {
            type: String,
            default: 'titolo',
        },
        src: {
            type: String,
            default: null,
        },
        titleAlign: {
            type: String,
            default: null,
        },
        hasAge: {
            type: Boolean,
            default: true,
        },
        color: {
            type: String,
            default: null,
        },
        translations: {
            type: Array,
            default: function () {
                return []
            },
        },
        ages: {
            type: Array,
            default: function () {
                return []
            },
        },
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
            lnTitle: null,
            age: null,
        }
    },
    watch: {
        src: function (src) {
            this.changeSrc()
        },
        '$root.locale': function (locale) {
            this.translateTitle(locale)
            this.translateAge(locale)
        }
    },
    computed: {
        player: function () {
            return this.$refs.player.player
        },
        topAlignClass: function () {
            if (this.titleAlign == 'center') {
                return 'ua-prop-player--top-center'
            }
        },
        colorClass: function () {
            if (this.color) {
                return 'ua-prop-player--' + this.color
            }
        }
    },
    methods: {
        translateTitle: function (locale = 'en') {
            let translation = this.translations.find(translation => translation.locale == locale)
            if (translation) {
                this.lnTitle = translation.title
            }
            else {
                this.lnTitle = this.title
            }
        },
        translateAge: function (locale = 'en') {
            let translation = this.ages.find(translation => translation.locale == locale)
            if (translation) {
                this.age = translation.title
            }
        },
        changeSrc: function () {
            if (this.src) {
                delete this.playerOptions.poster
                this.playerOptions.sources[0].src = this.src
                console.log('dentro cambia', this.src);
            }
        },
        play: function () {
            this.player.play()
            this.$emit('play')
        },
        pause: function () {
            this.player.pause()
            this.$emit('pause')
        },
        stop: function () {
            this.player.pause()
            this.player.currentTime(0)
            this.$emit('stop')
        },
        backward: function () {
            this.player.pause()
            this.$emit('backward')
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
            this.$emit('forward')
            let position = this.player.currentTime()
        },
    },
    created: function () {
        this.changeSrc()
    },
    mounted: function () {
        this.translateTitle(this.$root.locale)
        this.translateAge(this.$root.locale)
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-prop-player {
    width: 100%;
    height: 100%;
    overflow: hidden;
    @include border-radius(12px);
    background-color: $light-gray;

    &__top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__center {
        overflow: hidden;
    }

    &__title {
        padding: $app-padding-x;
        color: $white;
        font-size: $h3-font-size;
        font-weight: bold;
    }

    &__age {
        padding: $app-padding-x * 1.1;
        background-color: $red;
    }

    &--top-center &__top {
        justify-content: center;
    }

    &--dark-gray {
        background-color: $dark-gray;
    }
}
</style>
