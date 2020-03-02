<template>
    <div class="audio-player">
        <div ref="player" class="ua-audio-preview__player"></div>
    </div>
</template>

<script>
import WaveSurfer from "wavesurfer.js";
import RegionsPlugin from "wavesurfer.js/src/plugin/regions.js";

export default {
    name: "AudioPlayer",
    props: {
        src: {
            type: String,
            default: "/video/empty-session.mp4"
        },
        noRegion: {
            type: Boolean,
            default: false
        }
    },
    data: function() {
        return {
            master: null,
            player: null
        };
    },
    watch: {
        src: function(src) {
            if (this.player) {
                this.changeSrc(src);
            } else {
                this.init();
            }
        }
    },
    methods: {
        init: function() {
            if (this.noRegion) {
                this.player = WaveSurfer.create({
                    container: this.$refs.player
                });
            } else {
                this.player = WaveSurfer.create({
                    container: this.$refs.player,
                    plugins: [RegionsPlugin.create({})]
                });
            }
            this.player.on("ready", () => {
                this.$emit("ready");
            });
            if (this.src) {
                this.changeSrc(this.src);
            }
        },
        changeSrc: function(src = null) {
            return new Promise((resolve, reject) => {
                if (src) {
                    this.player.load(src);
                    if (!this.noRegion) {
                        let duration = this.player.getDuration();
                        this.player.addRegion({
                            start: 0,
                            end: duration,
                            loop: true,
                            color: "hsla(100, 100%, 30%, 0.1)"
                        });
                    }
                    resolve();
                } else {
                    reject();
                }
            });
        },
        play: function() {
            this.player.play();
        },
        pause: function() {
            this.player.pause();
        },
        stop: function() {
            if (this.player.isPlaying()) {
                this.player.pause();
                this.player.seekTo(0);
            }
        },
        backward: function() {
            this.player.skipBackward(5);
        },
        forward: function() {
            this.player.skipForward(5);
        }
    },
    mounted: function() {
        this.init();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
