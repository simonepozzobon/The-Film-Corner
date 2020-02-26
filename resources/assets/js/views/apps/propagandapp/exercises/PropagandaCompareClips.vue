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
                        :title="clip | translate('title', $root.locale)"
                        title-align="center"
                        :src="clip.video"
                        :clip="clip"
                        :captions="clip.captions"
                        :has-info="true"
                        @open-info="openInfo"
                    />
                </div>
                <div class="prop-compare-clips__right">
                    <ui-app-propaganda-player
                        ref="right"
                        class="prop-compare-clips__player"
                        color="dark-gray"
                        :has-age="false"
                        :title="compare | translate('title', $root.locale)"
                        title-align="center"
                        :src="compare.video ? compare.video : compare.url"
                        :clip="compare"
                        :captions="compare.captions"
                        :has-info="true"
                        @open-info="openInfo"
                    />
                </div>
            </div>
            <div
                class="prop-compare-clips__library"
                v-if="movies"
            >
                <slider-library
                    :movies="movies"
                    @change-video="changeVideo"
                    @open-modal="openModal"
                />
                <slider-modal-panel
                    ref="modal"
                    :modal="modal"
                />
            </div>
        </div>
    </template>
</propaganda-exercise-template>
</template>

<script>
import Utility from '../../../../Utilities'
import TranslationFilter from '../../../../TranslationFilter'
import PropagandaExerciseTemplate from './PropagandaExerciseTemplate.vue'
import SliderLibrary from '../../../../uiapp/sub/propaganda/SliderLibrary.vue'
import SliderModalPanel from '../../../../uiapp/sub/propaganda/SliderModalPanel.vue'

import {
    UiAppPropagandaPlayer,
    UiAppCroppedFrames,
}
from '../../../../uiapp'

export default {
    name: 'PropagandaCompareClips',
    mixins: [TranslationFilter],
    components: {
        PropagandaExerciseTemplate,
        SliderLibrary,
        SliderModalPanel,
        UiAppPropagandaPlayer,
        UiAppCroppedFrames,
    },
    data: function () {
        return {
            content: null,
            clip: null,
            compare: null,
            frames: [],
            movies: [],
            modal: null,
            session: null,
        }
    },
    watch: {
        session: function (session) {
            this.$root.session = Object.assign({}, session)
        },
        compare: function (clip) {
            let session = Object.assign({}, this.session)
            session.content['compare'] = clip
            this.session = session
        },
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

            // console.log('session', this.$root.session);
            if (this.$root.session && this.$root.session.app_id == 20 && this.$root.session.token) {
                url = '/api/v2/propaganda/clip/' + id + '/exercise/' + exerciseId + '/' + this.$root.session.token
            }


            // url = '/api/v2/propaganda/clip/' + id + '/exercise/' + exerciseId + '/5e56141cc778e'
            this.$http.get(url).then(response => {
                // console.log(response.data);
                const {
                    clip,
                    exercise,
                    session
                } = response.data

                this.clip = clip
                // this.compare = clip
                this.content = exercise
                this.movies = exercise.library.medias

                let formattedSession = session
                let content = session.content ? JSON.parse(session.content) : {}

                if (!content.hasOwnProperty('compare')) {
                    this.compare = clip
                }
                else {
                    this.compare = content.compare
                }

                formattedSession.content = {
                    ...content
                }

                this.session = Object.assign({}, formattedSession)
                this.$nextTick(this.init)
            })

            // this.clip = movies.find(movie => movie.id == id)
            // this.compare = this.clip
            // this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
        },
        init: function () {
            // if (this.session.content.compare) {
            //     // this.compare = this.session.content.compare
            //     console.log(this.session.content.compare);
            // }
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
        changeVideo: function (movie) {
            // console.log('compare changed');
            this.compare = Object.assign({}, movie)
            // console.log(this.compare);
        },
        openModal: function (modal) {
            this.modal = Object.assign({}, modal)
            this.$nextTick(() => {
                this.$refs.modal.show()
            })
        },
        openInfo: function (modal) {
            this.modal = Object.assign({}, modal)
            this.$nextTick(() => {
                this.$refs.modal.show()
            })
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
