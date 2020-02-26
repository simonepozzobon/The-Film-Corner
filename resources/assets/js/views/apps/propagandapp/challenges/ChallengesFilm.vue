<template>
<ui-container>
    <div class="propaganda-back">
        <div class="propaganda-back__container">
            <div class="propaganda-back__content">
                <ui-container class="prop-ex-container">
                    <ui-container
                        :contain="true"
                        ref="folder"
                        v-if="content"
                    >
                        <ui-row>
                            <ui-block
                                size="auto"
                                direction="row"
                                align="end"
                                justify="end"
                            >

                                <ui-app-challenges-breadcrumbs :app="content | translate('title', $root.locale)" />

                                <ui-folder-corner
                                    @click="togglePanel"
                                    color="dark-gray"
                                    cross="white"
                                    :has-times="open"
                                />

                            </ui-block>
                        </ui-row>
                        <ui-row justify="center">
                            <ui-block
                                size="auto"
                                color="dark-gray"
                                :radius="true"
                                radius-size="md"
                            >
                                <ui-title
                                    tag="h2"
                                    font-size="h2"
                                    :title="content | translate('title', $root.locale)"
                                    class="pt-5"
                                    color="white"
                                />
                                <ui-paragraph
                                    color="white"
                                    class="pt-5 prop-ex-container__paragraph"
                                    align="justify"
                                    v-html="description"
                                />
                            </ui-block>
                        </ui-row>
                    </ui-container>
                    <ui-container
                        :contain="true"
                        class="prop-films"
                    >
                        <ui-row justify="center">
                            <ui-block
                                size="auto"
                                color="dark-gray"
                                :radius="true"
                                radius-size="md"
                            >
                                <ui-special-text
                                    :text="$root.getCmd('watch_propaganda_films')"
                                    class="pt-5"
                                    color="white"
                                />

                                <div
                                    class="ch-film"
                                    v-if="library && library.medias.length > 0"
                                >
                                    <video-slider
                                        :movies="library.medias"
                                        @open-modal="openModal"
                                    />
                                </div>
                                <challenge-modal
                                    ref="modal"
                                    type="video"
                                    :modal="modal"
                                />
                            </ui-block>
                        </ui-row>
                    </ui-container>
                    <ui-container
                        :contain="true"
                        class="prop-upload"
                    >
                        <ui-app-block
                            :title="$root.getCmd('upload_propaganda_film')"
                            title-color="white"
                            color="dark"
                        >
                            <div class="form-group">
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    :placeholder="$root.getCmd('title')"
                                    v-model="challengeTitle"
                                >
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input
                                        type="file"
                                        class="custom-file-input"
                                        accept="video/mp4"
                                        @change="filesChange($event.target.name, $event.target.files)"
                                    >

                                    <label
                                        class="custom-file-label"
                                        for="inputGroupFile04"
                                    >
                                        {{ $root.getCmd('select_file') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group form-disclaimer">
                                <div class="form-disclaimer__icon">
                                    <span>i</span>
                                </div>
                                <div class="form-disclaimer__warning">
                                    {{ $root.getCmd('upload_disclaimer') }}
                                </div>
                            </div>
                            <ui-button
                                class="mt-4"
                                :has-margin="false"
                                color="yellow"
                                align="center"
                                :has-spinner="isLoading"
                                :disable="isLoading"
                                @click="upload"
                                :title="$root.getCmd('upload')"
                            />
                        </ui-app-block>
                    </ui-container>
                </ui-container>
            </div>
        </div>
    </div>
</ui-container>
</template>

<script>
const clipper = require('text-clipper')
import {
    challenges
}
from '../../../../dummies/PropagandAppContent'

import Utility from '../../../../Utilities'
import TranslationFilter from '../../../../TranslationFilter'
import {
    UiBlock,
    UiBreadcrumbs,
    UiButton,
    UiContainer,
    UiFolderCorner,
    UiHeroBanner,
    UiHeroImage,
    UiLink,
    UiParagraph,
    UiRoadmap,
    UiSpecialText,
    UiTitle,
    UiRow,
    UiImageSlider,
}
from '../../../../ui'

import {
    UiAppDepthTexts,
    UiAppChallengesBreadcrumbs,
    UiAppPropagandaPlayer,
    UiAppBlock,
}
from '../../../../uiapp'

import VideoSlider from '../../../../uiapp/sub/propaganda/VideoSlider.vue'
import ChallengeModal from '../../../../uiapp/sub/propaganda/ChallengeModal.vue'

export default {
    name: 'ChallengePropagandaFilm',
    mixins: [TranslationFilter],
    components: {
        UiAppChallengesBreadcrumbs,
        UiBlock,
        UiBreadcrumbs,
        UiButton,
        UiContainer,
        UiFolderCorner,
        UiHeroBanner,
        UiHeroImage,
        UiLink,
        UiParagraph,
        UiRoadmap,
        UiSpecialText,
        UiTitle,
        UiRow,
        UiImageSlider,
        UiAppBlock,
        VideoSlider,
        ChallengeModal,
    },
    data: function () {
        return {
            clip: null,
            title: null,
            challengeTitle: null,
            file: null,
            isLoading: false,
            content: null,
            open: false,
            description: null,
            buttonText: null,
            library: null,
            modal: null,
        }
    },
    watch: {
        content: function (content) {
            this.description = this.$options.filters.translate(content, 'description', this.$root.locale)
        },
    },
    computed: {},
    methods: {
        getData: function () {
            let id = 1
            // perform api call
            this.$http.get(`/api/v2/propaganda/challenge/${id}`).then(response => {
                console.log(response.data);
                if (response.data.success) {
                    const {
                        challenge,
                        library
                    } = response.data

                    this.content = challenge
                    this.library = library
                }
            }).catch(err => {
                this.content = challenges.find(challenge => challenge.id == id)
            })

            // this.debug()
        },
        debug: function () {
            console.log(this.content);
            // this.selectChannel(this.channels[2])
        },
        enter: function () {},
        leave: function () {},
        startApp: function () {
            console.log(this.content.slug);
            this.$root.goTo('propaganda-film-app')
        },
        filesChange: function (name, files) {
            this.file = files[0]
            this.error_msg = null
            console.log(files);
        },
        togglePanel: function () {
            if (this.open) {
                this.open = false
                this.description = this.$options.filters.translate(this.content, 'description', this.$root.locale)
                this.buttonText = this.$root.getCmd('open_existing_session')
            }
            else {
                this.open = true
                let description = this.$options.filters.translate(this.content, 'description', this.$root.locale)
                this.description = clipper(description, 150, {
                    html: true
                })
                this.buttonText = this.$root.getCmd('read_more')
            }
        },
        upload: function () {
            this.isLoading = true

            let data = new FormData()
            data.append('title', this.challengeTitle)
            data.append('media', this.file)
            data.append('challenge_id', 1)
            data.append('library_type_id', 1)

            this.$http.post('/api/v2/propaganda/challenge/apps/upload-content', data).then(response => {
                // console.log(response.data);
                this.isLoading = false

                if (response.data.success) {
                    let library = this.library
                    this.library = null

                    library.medias.push(response.data.media)

                    this.library = Object.assign({}, library)
                }
            }).catch(err => {
                // console.log(err);
                this.isLoading = false
            })
        },
        openModal: function (movie) {
            console.log('opening-modal');
            this.modal = Object.assign({}, movie)
            this.$nextTick(() => {
                this.$refs.modal.show()
            })
        },
    },
    created: function () {
        this.getData()
    },
    mounted: function () {},
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.form-disclaimer {
    margin-top: $spacer * 2;
    display: flex;
    align-items: center;
    width: 100%;

    &__icon {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: $gray-600;
        width: $spacer * 3;
        height: $spacer * 3;
        @include border-radius(50%);

        span {
            color: $danger;
            font-weight: $font-weight-bold;
            font-size: $h3-font-size;
        }
    }

    &__warning {
        line-height: 1;
        display: block;
        color: $white;
        margin-left: $spacer;
    }
}

.propaganda-back {
    padding-top: 90px;
    background-image: url("/img/grafica/propaganda/bg-app-80.jpg");
    background-position: top;
    background-size: cover;

    &__container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    &__content {
        padding: $spacer * 2;
    }
}

.ch-film {
    width: 90%;
    padding-bottom: $spacer * 2;
}

.prop-films {
    margin-top: $spacer * 2;

    &__container {
        position: relative;
        max-width: 100%;
        overflow: hidden;
        padding-bottom: $spacer * 4;
    }
}

.prop-upload {
    margin-top: $spacer * 2;
}

.prop-ex-container {
    // margin-top: $spacer * 5;

    &__paragraph-container {
        // display: flex;
        // flex-direction: column;
        // justify-content: flex-start;
    }

    &__paragraph {}

    &--is-open &__paragraph {}
}
</style>
