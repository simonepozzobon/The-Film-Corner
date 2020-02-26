<template>
<div class="ua-single-res">
    <div class="ua-single-res__container">
        <div
            class="ua-single-res__thumb"
            @click="openResult"
        >
            <div class="ua-single-res__thumb-container">
                <ui-image
                    v-if="content.thumb"
                    :src="content.thumb"
                    :alt="content | translate('title', $root.locale)"
                    :has-margin="false"
                />
                <div class="overlay">
                    <single-hover />
                </div>
                <!-- <video
                    ref="player"
                    class="video-js d-none"
                ></video> -->
            </div>
        </div>
        <div class="ua-single-res__details">
            <div class="ua-single-res__title">
                <ui-title
                    :title="content | translate('title', $root.locale)"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                    tag="h3"
                    font-size="h6"
                />
            </div>
            <div class="ua-single-res__year">
                {{ content.year }}
            </div>
            <div class="ua-single-res__director">
                <span
                    v-for="(director, i) in content.directors"
                    :key="director.id"
                >
                    <span v-if="i < content.directors.length - 1">{{ director.name }}, </span>
                    <span v-else>{{ director.name }}</span>
                </span>
            </div>
            <div class="ua-single-res__country">
                <span v-if="content.duration">
                    {{ content.nationality }}, {{ content.duration }}'
                </span>
                <span v-else>
                    {{ content.nationality }}
                </span>
            </div>
            <div class="ua-single-res__attributes">
                <div class="ua-single-res__attribute">
                    <span>{{ content.format.title }}</span>

                </div>
            </div>
            <div class="ua-single-res__tags">
                <div
                    class="ua-single-res__tag"
                    v-for="(topic, i) in content.topics"
                    :key="topic.id"
                >
                    <span v-if="i != content.topics.length - 1 ">
                        {{ topic.title }},&nbsp;
                    </span>
                    <span v-else>
                        {{ topic.title }}
                    </span>
                </div>
            </div>
            <div
                class="ua-single-res__tags"
                v-if="content.tags"
            >
                <div
                    class="ua-single-res__tag"
                    v-for="(tag, i) in content.tags"
                    :key="tag.id"
                >
                    <span v-if="i != content.tags.length - 1 ">
                        {{ tag.title }},&nbsp;
                    </span>
                    <span v-else>
                        {{ tag.title }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    UiImage,
    UiTitle,
}
from '../../../ui'

import SingleHover from './SingleHover.vue'
import videojs from 'video.js'
import TranslationFilter from '../../../TranslationFilter'

export default {
    name: 'SingleResult',
    mixins: [TranslationFilter],
    components: {
        SingleHover,
        UiImage,
        UiTitle,
    },
    props: {
        content: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            posterSrc: null,
            playerReady: false,
            options: {
                aspectRatio: '16:9',
                controls: true,
                preload: 'auto',
                width: 480,
                height: 270,
            }
        }
    },
    // watch: {
    //     'content.src': function (src) {
    //         if (this.player && this.playerReady) {
    //             this.setSrc()
    //         }
    //     },
    // },
    methods: {
        initPlayer: function () {
            this.player = videojs(this.$refs.player, this.options, () => {
                this.playerReady = true
                if (this.content.video) {
                    this.setSrc()
                }
            })
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

            let ctx = canvas.getContext('2d')
            ctx.drawImage(player, 0, 0)

            this.posterSrc = canvas.toDataURL()
            console.log(this.posterSrc);
        },
        openResult: function () {
            this.$emit('open-result', this.content)
        },
        setSrc: function () {
            this.player.src({
                type: 'video/mp4',
                src: this.content.video
            })
        },
    },
    mounted: function () {
        // this.initPlayer()
    },
    // beforeDestroy: function () {
    //     if (this.player) {
    //         this.player.dispose()
    //     }
    // }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-single-res {
    margin-bottom: $spacer * 2;

    &__container {
        display: flex;
    }

    &__thumb {
        flex: 40% 1 1;
        max-width: 40%;
    }

    &__thumb-container {
        position: relative;
        @include border-radius($spacer / 2.8);
        overflow: hidden;
        max-height: 100%;
        cursor: pointer;

        .overlay {
            position: absolute;
            background-color: rgba($black, 0.3);
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: $transition-base;
            z-index: 1;
        }
    }

    &__details {
        flex: 60% 1 1;
        max-width: 60%;
        margin-left: $spacer;
    }

    &__attributes,
    &__tags {
        display: flex;
        justify-content: flex-start;
    }

    &:hover & {
        &__thumb-container {
            .overlay {
                opacity: 1;
                transition: $transition-base;
            }
        }
    }
}
</style>
