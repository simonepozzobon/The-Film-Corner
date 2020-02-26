<template>
<propaganda-exercise-template
    :content="content"
    :clip="clip"
    v-if="content && clip"
>
    <template slot="preview">
        <div class="prop-frame-crop">
            <div class="prop-frame-crop__preview">
                <ui-app-propaganda-player
                    ref="player"
                    class="prop-frame-crop__player"
                    color="dark-gray"
                    :has-age="false"
                    :title="clip | translate('title', $root.locale)"
                    title-align="center"
                    :src="clip.video"
                    :captions="clip.captions"
                />
            </div>
            <div class="prop-frame-crop__btns">
                <ui-button
                    class="prop-frame-crop__btn"
                    :title="$root.getCmd('crop_a_frame')"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                    display="inline-block"
                    color="black"
                    @click="cropFrame"
                />
                <ui-button
                    class="prop-frame-crop__btn"
                    :title="$root.getCmd('delete_all')"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                    display="inline-block"
                    color="black"
                    @click="deleteAll"
                />
            </div>
        </div>
    </template>
    <ui-app-cropped-frames
        :frames="this.frames"
        @delete-frame="deleteFrame"
        @changed="updateFrame"
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
import TranslationFilter from '../../../../TranslationFilter'
import PropagandaExerciseTemplate from './PropagandaExerciseTemplate.vue'

import {
    UiAppPropagandaPlayer,
    UiAppCroppedFrames,
}
from '../../../../uiapp'

import {
    UiButton
}
from '../../../../ui'

export default {
    name: 'PropagandaFrameCrop',
    mixins: [TranslationFilter],
    components: {
        PropagandaExerciseTemplate,
        UiAppPropagandaPlayer,
        UiAppCroppedFrames,
        UiButton,
    },
    data: function () {
        return {
            content: null,
            clip: null,
            frames: [],
            session: null,
        }
    },
    watch: {
        session: function (session) {
            // console.log('changing session', session);
            this.$root.session = Object.assign({}, session)
        },
        frames: function (frames) {
            // console.log('changing frames');
            let session = Object.assign({}, this.session)
            session.content['frames'] = frames

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
                const {
                    clip,
                    exercise,
                    session
                } = response.data

                this.clip = clip
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
            // this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
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
        cropFrame: function () {
            let video = this.player.el().querySelector('video')
            let canvas = document.createElement('canvas')
            canvas.width = video.videoWidth
            canvas.height = video.videoHeight

            canvas.getContext('2d').drawImage(video, 0, 0)

            let dataUri = canvas.toDataURL('image/jpeg')

            let frames = this.frames
            let frame = {
                id: Utility.uuid(),
                text: null,
                img: dataUri,
            }

            frames.push(frame)
            this.frames = Object.assign([], frames)
        },
        deleteAll: function () {
            this.frames = []
        },
        updateFrame: function (value, uuid) {
            let idx = this.frames.findIndex(frame => frame.id == uuid)
            if (idx > -1) {
                this.frames[idx].text = value
            }

        },
        deleteFrame: function (id) {
            this.frames = Object.assign([], this.frames.filter(frame => frame.id != id))
        },
    },
    created: function () {
        this.$root.isApp = true
    },
    mounted: function () {
        this.getData()
    },
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.prop-frame-crop {
    margin-top: $spacer * 2;

    &__preview {
        width: 100%;
        height: 100%;
        background-color: $dark-gray;
        @include border-radius(12px);
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
