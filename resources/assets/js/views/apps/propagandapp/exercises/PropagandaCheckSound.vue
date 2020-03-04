<template>
<propaganda-exercise-template
    :content="content"
    :clip="clip"
    v-if="content && clip"
>
    <template slot="preview">
        <div class="prop-check-sound">
            <div class="prop-check-sound__preview">
                <ui-app-propaganda-player
                    ref="player"
                    class="prop-frame-crop__player"
                    color="dark-gray"
                    :has-age="false"
                    :title="clip | translate('title', $root.locale)"
                    title-align="center"
                    :src="clip.video"
                    :captions="clip.captions"
                    :muted="true"
                    :isMp4="true"
                    @play="play"
                    @pause="pause"
                    @stop="stop"
                    @backward="backward"
                    @forward="forward"
                />
            </div>
            <div class="prop-check-sound__player">
                <audio-player
                    ref="audio"
                    :src="clip.video"
                    :has-spinner="true"
                    @ready="setPlayerReady"
                    @seek="setPlayerCurrentTime"
                />
            </div>
            <div class="prop-check-sound__btns">
                <ui-button
                    class="prop-check-sound__btn"
                    :title="$root.getCmd('insert_bookmark')"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                    display="inline-block"
                    color="black"
                    @click="addBookmark"
                />
            </div>
        </div>
    </template>
    <ui-app-note
        class="mt-4"
        color="yellow"
        @changed="updateNote"
        :initial="notes"
    />
</propaganda-exercise-template>
</template>

<script>
import {
    movies
}
from "../../../../dummies/PropagandAppContent";

import Utility from "../../../../Utilities";
import TranslationFilter from "../../../../TranslationFilter";
import PropagandaExerciseTemplate from "./PropagandaExerciseTemplate.vue";
import AudioPlayer from "../../../../uiapp/sub/propaganda/AudioPlayer.vue";

import {
    UiAppCroppedFrames,
    UiAppNote,
    UiAppPropagandaPlayer
}
from "../../../../uiapp";

import {
    UiButton
}
from "../../../../ui";

export default {
    name: "PropagandaCheckSound",
    mixins: [TranslationFilter],
    components: {
        AudioPlayer,
        PropagandaExerciseTemplate,
        UiAppCroppedFrames,
        UiAppNote,
        UiAppPropagandaPlayer,
        UiButton
    },
    data: function () {
        return {
            content: null,
            clip: null,
            compare: null,
            frames: [],
            movies: movies,
            notes: null,
            bookmarks: [],
            session: null,
            playerReady: false,
            initialized: false
        };
    },
    watch: {
        session: function (session) {
            this.$root.session = Object.assign({}, session);
        },
        bookmarks: function (bookmarks) {
            let session = Object.assign({}, this.session);
            session.content["bookmarks"] = bookmarks;
            this.session = session;
        },
        notes: function (notes) {
            let session = Object.assign({}, this.session);
            session.content["notes"] = notes;
            this.session = session;
        },
        initialized: function (v) {
            if (this.playerReady) {
                this.init();
            }
        },
        playerReady: function (v) {
            if (this.initialized) {
                this.init();
            }
        },
    },
    computed: {
        player: function () {
            return this.$refs.player.player;
        }
    },
    methods: {
        uniqid: function () {
            let ts = String(new Date().getTime()),
                i = 0,
                out = "";
            for (i = 0; i < ts.length; i += 2) {
                out += Number(ts.substr(i, 2)).toString(36);
            }
            return "d" + out;
        },
        uniqidSimple: function () {
            return (
                "_" +
                Math.random()
                .toString(36)
                .substr(2, 9)
            );
        },
        setPlayerReady: function () {
            this.playerReady = true;
        },
        setPlayerCurrentTime: function (progress, time) {
            // console.log(progress, time);
            if (this.$refs.player && this.$refs.player.player) {
                this.$refs.player.player.currentTime(time)
            }
        },
        getData: function () {
            window.addEventListener("beforeunload", () => {
                try {
                    this.deleteEmptySession();
                }
                catch (e) {}
                finally {}
            });

            let id = this.$route.params.id;
            let exerciseId = this.$route.params.exerciseId;
            // perform api call
            let url = `/api/v2/propaganda/clip/${id}/exercise/${exerciseId}`;
            // console.log('session', this.$root.session);
            if (
                this.$root.session &&
                this.$root.session.app_id == 21 &&
                this.$root.session.token
            ) {
                console.log('apri sessions');
                url = `/api/v2/propaganda/clip/${id}/exercise/${exerciseId}/${this.$root.session.token}`;
            }

            // url = '/api/v2/propaganda/clip/' + id + '/exercise/' + exerciseId + '/5e553d29488d3'

            this.$http.get(url).then(response => {
                // console.log(response);
                const {
                    clip,
                    exercise,
                    session
                } = response.data;

                this.clip = clip;
                this.compare = clip;
                this.content = exercise;

                let formattedSession = session;
                let content = session.content ? JSON.parse(session.content) : {};
                formattedSession.content = {
                    ...content
                };
                this.session = Object.assign({}, formattedSession);

                this.$nextTick(() => {
                    this.initialized = true;
                });
            });

            // this.clip = movies.find(movie => movie.id == id)
            // this.compare = this.clip
            // this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
        },
        init: function () {
            // console.log(this.session);
            if (
                this.session.content.bookmarks &&
                this.session.content.bookmarks.length > 0
            ) {
                let bookmarks = [];
                let player = this.$refs.audio.player;

                for (
                    let i = 0; i < this.session.content.bookmarks.length; i++
                ) {
                    let bookmark = this.session.content.bookmarks[i];
                    // console.log(this.player);
                    player.addRegion(bookmark);
                    bookmarks.push(bookmark);
                }
                this.bookmarks = bookmarks;
            }

            if (this.session.content.notes) {
                this.notes = this.session.content.notes;
            }
        },
        play: function () {
            this.$refs.audio.play();
            // this.$refs.player.play();
        },
        pause: function () {
            this.$refs.audio.pause();
            // this.$refs.player.pause();
        },
        stop: function () {
            this.$refs.audio.stop();
            // this.$refs.player.stop();
        },
        backward: function () {
            this.$refs.audio.backward();
            // this.$refs.player.backward();
        },
        forward: function () {
            this.$refs.audio.forward();
            // this.$refs.player.forward();
        },
        addBookmark: function () {
            this.pause();
            this.$refs.player.pause();
            let audioPlayer = this.$refs.audio.player;
            let currentTime = audioPlayer.getCurrentTime();
            let endTime = currentTime + 0.1;

            let newRegion = {
                uuid: this.uniqid(),
                start: currentTime,
                end: endTime,
                loop: false,
                color: "hsla(100, 100%, 30%, 1)"
            };

            this.bookmarks.push(newRegion);
            audioPlayer.addRegion(newRegion);
        },
        deleteEmptySession: function () {
            // verificare se è vuota
            if (Boolean(this.session.is_empty)) {
                this.$http.delete(
                    "/api/v2/session/" + this.session.token + "/true"
                );
            }
            this.$nextTick(() => {
                this.$root.session = null;
            });
        },
        updateNote: function (notes) {
            this.notes = notes;
        }
    },
    created: function () {
        this.$root.isApp = true;
    },
    mounted: function () {
        this.$nextTick(() => {
            this.getData();
        })
    },
    beforeDestroy: function () {
        this.$root.isApp = false;
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";

.prop-check-sound {
    margin-top: $spacer * 2;

    &__preview {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__player {
        margin-top: $spacer * 2;
    }

    &__btns {
        margin-top: $spacer * 2;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    &__btn {
        margin-left: $spacer;
        margin-right: $spacer;
    }
}
</style>
