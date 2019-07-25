<template>
<propaganda-exercise-template
    :content="content"
    :clip="clip"
    v-if="content && clip"
>
    <template slot="preview">
        <div class="prop-compare-clips">
            <div class="prop-compare-clips__preview">
                <div class="prop-compare-clips__left">
                    <ui-app-propaganda-player
                        ref="player"
                        class="prop-compare-clips__player"
                        color="dark-gray"
                        :has-age="false"
                        :title="clip.title"
                        title-align="center"
                        :src="clip.video"
                    />
                </div>
                <div class="prop-compare-clips__right">
                    <ui-app-propaganda-player
                        ref="right"
                        class="prop-compare-clips__player"
                        color="dark-gray"
                        :has-age="false"
                        :title="compare.title"
                        title-align="center"
                        :src="compare.video"
                    />
                </div>
            </div>
            <div class="prop-compare-clips__library">
                <slider-library
                    :clips="movies"
                    @change-video="changeVideo"
                />
            </div>
        </div>
    </template>
</propaganda-exercise-template>
</template>

<script>
import {
    movies
}
from '../../../../dummies/PropagandAppContent'

import Utility from '../../../../Utilities'
import PropagandaExerciseTemplate from './PropagandaExerciseTemplate.vue'
import SliderLibrary from '../../../../uiapp/sub/propaganda/SliderLibrary.vue'

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
    name: 'PropagandaCompareClips',
    components: {
        PropagandaExerciseTemplate,
        SliderLibrary,
        UiAppPropagandaPlayer,
        UiAppCroppedFrames,
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
        playerRight: function () {
            return this.$refs.right.player
        },
    },
    methods: {
        getData: function () {
            let id = this.$route.params.id
            let exerciseId = this.$route.params.exerciseId
            // perform api call
            this.clip = movies.find(movie => movie.id == id)
            this.compare = this.clip
            this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
        },
        changeVideo: function (clip) {
            this.compare = Object.assign({}, clip)
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
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.prop-compare-clips {
    margin-top: $spacer * 2;

    &__preview {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__left,
    &__right {
        flex: 50% 1 1;
        max-width: 50%;
    }

    &__left {
        margin-right: $spacer * 2;
    }

    &__right {
        margin-left: $spacer * 2;
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
