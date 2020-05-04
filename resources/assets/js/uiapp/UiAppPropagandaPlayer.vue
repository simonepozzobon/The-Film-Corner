<template>
    <div
        class="ua-prop-player"
        :class="[topAlignClass, colorClass, hasInfoClass]"
    >
        <div class="ua-prop-player__container">
            <div class="ua-prop-player__top">
                <div class="ua-prop-player__title">
                    <ui-title
                        v-if="!hasInfo"
                        :title="lnTitle"
                        tag="h2"
                        font-size="h4"
                        :align="titleAlign"
                        :has-container="false"
                        :has-margin="false"
                        :has-padding="false"
                    />

                    <ui-title
                        v-else
                        :title="lnTitle"
                        tag="h3"
                        font-size="h5"
                        :has-container="false"
                        :has-margin="false"
                        :has-padding="false"
                    />
                </div>
                <div
                    v-if="hasInfo"
                    class="ua-prop-player__info"
                    @click.prevent="openInfo"
                >
                    <span>i</span>
                </div>
                <div class="ua-prop-player__age" v-if="hasAge">
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
                    @ready="onPlayerReady"
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
import Controls from "./sub/propaganda/Controls.vue";

import { UiTitle } from "../ui";

import { videoPlayer } from "vue-video-player";

export default {
    name: "UiAppPropagandaPlayer",
    components: {
        Controls,
        UiTitle,
        videoPlayer
    },
    props: {
        title: {
            type: String,
            default: "titolo"
        },
        src: {
            type: String,
            default: null
        },
        titleAlign: {
            type: String,
            default: null
        },
        hasAge: {
            type: Boolean,
            default: true
        },
        color: {
            type: String,
            default: null
        },
        translations: {
            type: Array,
            default: function() {
                return [];
            }
        },
        ages: {
            type: Array,
            default: function() {
                return [];
            }
        },
        clip: {
            type: Object,
            default: function() {
                return {};
            }
        },
        debug: {
            type: Boolean,
            default: false
        },
        hasInfo: {
            type: Boolean,
            default: false
        },
        muted: {
            type: Boolean,
            default: false
        },
        isMp4: {
            type: Boolean,
            default: false
        },
        captions: {
            type: Array,
            default: function() {
                return [];
            }
        },
        hasControls: {
            type: Boolean,
            default: true
        }
    },
    data: function() {
        return {
            master: null,
            loaderVisible: false,
            playerOptions: {
                aspectRatio: "16:9",
                languages: ["en", "it", "fr", "sl", "ka", "sr"],
                sources: [
                    {
                        type: "video/mp4",
                        src: "/video/empty-session.mp4"
                    }
                ],
                poster: "/video/empty-session.png"
            },
            lnTitle: null,
            age: null
        };
    },
    watch: {
        src: function(src) {
            this.changeSrc();
        },
        "$root.locale": function(locale) {
            this.translateTitle(locale);
            this.translateAge(locale);

            this.translateCaptions(locale);
        },
        clip: function() {
            if (this.debug) {
                // console.log('cambiata dentroooo');
            }
        }
    },
    computed: {
        player: function() {
            return this.$refs.player.player;
        },
        topAlignClass: function() {
            if (this.titleAlign == "center") {
                return "ua-prop-player--top-center";
            }
            return null;
        },
        colorClass: function() {
            if (this.color) {
                return "ua-prop-player--" + this.color;
            }
            return null;
        },
        hasInfoClass: function() {
            if (this.hasInfo) {
                return "ua-prop-player--has-info";
            }
            return null;
        }
    },
    methods: {
        translateTitle: function(locale = "en") {
            let translation = this.translations.find(
                translation => translation.locale == locale
            );
            if (translation) {
                this.lnTitle = translation.title;
            } else {
                this.lnTitle = this.title;
            }
        },
        translateAge: function(locale = "en") {
            let translation = this.ages.find(
                translation => translation.locale == locale
            );
            if (translation) {
                this.age = translation.title;
            }
        },
        changeSrc: function() {
            if (this.src) {
                delete this.playerOptions.poster;
                this.playerOptions.sources[0].src = this.src;
                console.log("dentro cambia", this.src);
                const locale = this.$root.locale;
                this.$nextTick(() => {
                    this.translateTitle(locale);
                    this.translateAge(locale);
                    this.translateCaptions(locale);
                });
            }
        },
        play: function() {
            this.player.play();
            this.$emit("play");
        },
        pause: function() {
            this.player.pause();
            this.$emit("pause");
        },
        stop: function() {
            this.player.pause();
            this.player.currentTime(0);
            this.$emit("stop");
        },
        backward: function() {
            this.player.pause();
            let position = this.player.currentTime();
            if (position >= 5) {
                this.player.currentTime(position - 5);
            } else {
                this.player.currentTime(0);
            }
            this.$emit("backward");
        },
        forward: function() {
            this.player.pause();
            let position = this.player.currentTime();
            this.player.currentTime(position + 5);
            this.$emit("forward");
        },
        openInfo: function() {
            this.$emit("open-info", this.clip);
        },
        translateCaptions: function() {
            // console.log('translateCaption', this.captions);
            if (this.player) {
                let tracks = this.player.textTracks();

                // console.log(tracks.length);

                for (let i = 0; i < tracks.length; i++) {
                    let track = tracks[i];
                    if (track.kind == "subtitles" && track.mode == "showing") {
                        track.mode = "disabled";
                    }
                }

                for (let i = 0; i < tracks.length; i++) {
                    let track = tracks[i];
                    if (
                        track.kind == "subtitles" &&
                        track.language == this.$root.locale
                    ) {
                        track.mode = "showing";
                    }
                }
            }
        },
        onPlayerReady: function() {
            // console.log('player ready');
            for (let i = 0; i < this.captions.length; i++) {
                let caption = this.captions[i];

                this.player.addRemoteTextTrack(
                    {
                        src: caption.src,
                        kind: "subtitles",
                        srclang: caption.locale,
                        label: caption.locale
                    },
                    true
                );

                let tracks = this.player.textTracks();

                for (let j = 0; j < tracks.length; j++) {
                    let track = tracks[j];

                    if (
                        track.kind == "subtitles" &&
                        track.language == this.$root.locale
                    ) {
                        track.mode = "showing";
                    }
                }
            }
            // this.$nextTick(() => {
            //     console.log(this.player.textTracks());
            // })
            this.$emit("ready");
        }
    },
    created: function() {
        if (this.muted) {
            this.playerOptions = Object.assign(this.playerOptions, {
                muted: true
            });
        }

        if (this.isMp4) {
            this.playerOptions = Object.assign(this.playerOptions, {
                partialRender: true
            });
        }

        if (this.hasControls == false) {
            this.playersOptions = Object.assign(this.playerOptions, {
                controls: false
            });
        }

        this.changeSrc();
    },
    mounted: function() {
        this.translateTitle(this.$root.locale);
        this.translateAge(this.$root.locale);
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";

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

    &__info {
        padding: $app-padding-x * 1.1;
        background-color: $gray-600;
        color: $green-var;
        font-size: $h3-font-size;
        font-weight: $font-weight-bold;
        width: $spacer * 3;
        height: $spacer * 3;
        display: flex;
        @include border-radius(50%);
        justify-content: center;
        align-items: center;
        cursor: pointer;

        span {
            display: block;
            cursor: pointer;
        }
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

    &--has-info {
        &__title {
            font-size: inherit;
            font-weight: inherit;
        }
    }
}
</style>
