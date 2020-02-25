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
        @changed="updateNote"
    />
</propaganda-exercise-template>
</template>

<script>
import {
    movies
}
from '../../../../dummies/PropagandAppContent'

import Utility from '../../../../Utilities'
import TranslationFilter from '../../../../TranslationFilter'
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
    mixins: [TranslationFilter],
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
            notes: null,
            bookmarks: [],
            session: null,
        }
    },
    watch: {
        session: function (session) {
            this.$root.session = Object.assign({}, session)
        },
        bookmarks: function (bookmarks) {
            let session = Object.assign({}, this.session)
            session.content['bookmarks'] = bookmarks
            this.session = session
        },
        notes: function (notes) {
            let session = Object.assign({}, this.session)
            session.content['notes'] = notes
            this.session = session
        }
    },
    computed: {
        player: function () {
            return this.$refs.player.player
        },
    },
    methods: {
        uniqid: function () {
            let ts = String(new Date().getTime()),
                i = 0,
                out = ''
            for (i = 0; i < ts.length; i += 2) {
                out += Number(ts.substr(i, 2)).toString(36)
            }
            return ('d' + out)
        },
        uniqidSimple: function () {
            return '_' + Math.random().toString(36).substr(2, 9)
        },
        getData: function () {
            window.addEventListener('beforeunload', () => {
                try {
                    this.deleteEmptySession()
                }
                catch (e) {

                }
                finally {

                }
            })

            let id = this.$route.params.id
            let exerciseId = this.$route.params.exerciseId
            // perform api call
            let url = '/api/v2/propaganda/clip/' + id + '/exercise/' + exerciseId
            this.$http.get(url).then(response => {
                console.log(response);
                const {
                    clip,
                    exercise,
                    session
                } = response.data

                this.clip = clip
                this.compare = clip
                this.content = exercise

                let formattedSession = session
                let content = session.content ? JSON.parse(session.content) : {}
                formattedSession.content = {
                    ...content,
                }
                this.session = Object.assign({}, formattedSession)

                this.$nextTick(this.init)
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
        addBookmark: function () {
            this.pause()
            let player = this.$refs.audio.player
            let currentTime = player.getCurrentTime()
            let endTime = currentTime + 0.1

            let newRegion = {
                uuid: this.uniqid(),
                start: currentTime,
                end: endTime,
                loop: false,
                color: 'hsla(100, 100%, 30%, 1)'
            }

            this.bookmarks.push(newRegion)
            player.addRegion(newRegion)
        },
        init: function () {
            if (this.$root.session && this.$root.session.app_id) {

            }
        },
        deleteEmptySession: function () {
            // verificare se è vuota
            if (Boolean(this.session.is_empty)) {
                this.$http.delete('/api/v2/session/' + this.session.token + '/true')
            }
            this.$nextTick(() => {
                this.$root.session = null
            })
        },
        updateNote: function (notes) {
            this.notes = notes
        }
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
