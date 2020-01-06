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
                    :title="clip.title"
                    title-align="center"
                    :src="clip.video"
                />
            </div>
            <div class="prop-frame-crop__btns">
                <ui-button
                    class="prop-frame-crop__btn"
                    title="Frame crop"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                    display="inline-block"
                    color="black"
                    @click="cropFrame"
                />
                <ui-button
                    class="prop-frame-crop__btn"
                    title="Delete All"
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
                this.content = response.data.exercise
            })

            // this.clip = movies.find(movie => movie.id == id)
            // this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
        },
        cropFrame: function () {
            let video = this.player.el().querySelector('video')
            let canvas = document.createElement('CANVAS')
            canvas.width = video.videoWidth
            canvas.height = video.videoHeight

            canvas.getContext('2d').drawImage(video, 0, 0)

            let dataUri = canvas.toDataURL('image/jpeg')

            let frame = {
                id: Utility.uuid(),
                text: null,
                img: dataUri,
            }

            this.frames.push(frame)
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
            this.frames = this.frames.filter(frame => frame.id != id)
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
