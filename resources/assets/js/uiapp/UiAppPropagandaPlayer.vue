<template>
<div class="ua-prop-player">
    <div class="ua-prop-player__container">
        <div class="ua-prop-player__top">
            <div class="ua-prop-player__title">
                <ui-title
                    :title="title"
                    tag="h2"
                    font-size="h4"
                    :has-container="false"
                    :has-margin="false"
                    :has-padding="false"
                />
            </div>
            <div class="ua-prop-player__age">
                <ui-title
                    title="14-18 anni"
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
                @timeupdate="onPlayerTimeUpdate($event)"
                @ready="$emit('ready')"
            />
        </div>
        <div class="ua-prop-player__controls">
            <controls />
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
            }
        }
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
}
</style>
