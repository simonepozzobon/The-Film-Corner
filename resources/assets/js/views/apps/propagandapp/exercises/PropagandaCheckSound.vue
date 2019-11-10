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
                    :title="clip.title"
                    title-align="center"
                    :src="clip.video"
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
                    src="/storage/apps/library/film-specific/sound/whats-going-on/audio/app/mp3/STORIE_SONORE_01_NOIR.mp3"
                />
            </div>
            <div class="prop-check-sound__btns">
                <ui-button
                    class="prop-check-sound__btn"
                    title="Insert Bookmark"
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
    />
</propaganda-exercise-template>
</template>

<script>
import {
    movies
}
from '../../../../dummies/PropagandAppContent'

import Utility from '../../../../Utilities'
import PropagandaExerciseTemplate from './PropagandaExerciseTemplate.vue'
import AudioPlayer from '../../../../uiapp/sub/propaganda/AudioPlayer.vue'

import {
    UiAppCroppedFrames,
    UiAppNote,
    UiAppPropagandaPlayer,
}
from '../../../../uiapp'

import {
    UiButton
}
from '../../../../ui'

export default {
    name: 'PropagandaCheckSound',
    components: {
        AudioPlayer,
        PropagandaExerciseTemplate,
        UiAppCroppedFrames,
        UiAppNote,
        UiAppPropagandaPlayer,
        UiButton,
    },
    data: function () {
        return {
            content: null,
            clip: null,
            compare: null,
            frames: [],
            movies: movies,
        }
    },
    computed: {
        player: function () {
            return this.$refs.player.player
        },
    },
    methods: {
        getData: function () {
            let id = this.$route.params.id
            let exerciseId = this.$route.params.exerciseId
            // perform api call
            let url = '/api/v2/propaganda/clip/' + id + '/exercise/' + exerciseId
            this.$http.get(url).then(response => {
                console.log(response);
                this.clip = response.data.clip
                this.compare = this.clip
                this.content = response.data.exercise
            })

            // this.clip = movies.find(movie => movie.id == id)
            // this.compare = this.clip
            // this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
        },
        play: function () {
            this.$refs.audio.play()
        },
        pause: function () {
            this.$refs.audio.pause()
        },
        stop: function () {
            this.$refs.audio.stop()
        },
        backward: function () {
            this.$refs.audio.backward()
        },
        forward: function () {
            this.$refs.audio.forward()
        },
        addBookmark: function () {},
    },
    created: function () {
        this.$root.isApp = true
    },
    mounted: function () {
        this.getData()
    },
    beforeDestroy: function () {
        this.$root.isApp = false
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

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
