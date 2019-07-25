<template>
<ui-container>
    <div class="propaganda-back">
        <div class="propaganda-back__container">
            <div class="propaganda-back__content">
                <ui-container class="prop-ex-container">
                    <ui-container
                        :contain="true"
                        ref="folder"
                    >
                        <ui-row>
                            <ui-block
                                size="auto"
                                direction="row"
                                align="end"
                                justify="end"
                            >

                                <ui-app-challenges-breadcrumbs :app="content.title" />

                                <ui-folder-corner
                                    color="dark-gray"
                                    cross="white"
                                    :has-times="false"
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
                                    :title="content.title"
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
                        class="prop-affiches"
                    >
                        <ui-row>
                            <ui-block
                                :size="6"
                                color="dark-gray"
                                :radius="true"
                                radius-size="md"
                            >
                                <div class="py-5">
                                    <p
                                        class="text-white h4 px-5"
                                        align="center"
                                    >
                                        Watch the video interviews of the TFC projects community.
                                    </p>
                                    <ui-button
                                        class="mt-4"
                                        :has-margin="false"
                                        color="yellow"
                                        align="center"
                                        @click="$root.goTo('propaganda-interviews-db')"
                                        title="Go To the database"
                                    />
                                </div>
                            </ui-block>
                            <ui-block
                                :size="6"
                                color="dark-gray"
                                :radius="true"
                                radius-size="md"
                            >
                                <div class="py-5">
                                    <p
                                        class="text-white h4 px-5"
                                        align="center"
                                    >
                                        Upload your interview
                                    </p>
                                    <p
                                        class="text-white px-5"
                                        align="center"
                                    >
                                        (Videos with audio, texts, audios).
                                    </p>
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            name="title"
                                            class="form-control"
                                            placeholder="Title"
                                            v-model="title"
                                        >
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input
                                                type="file"
                                                class="custom-file-input"
                                                accept="video/*, image/*"
                                                @change="filesChange($event.target.name, $event.target.files)"
                                            >

                                            <label
                                                class="custom-file-label"
                                                for="inputGroupFile04"
                                            >
                                                Choose file
                                            </label>
                                        </div>
                                    </div>
                                    <ui-button
                                        class="mt-4"
                                        :has-margin="false"
                                        color="yellow"
                                        align="center"
                                        @click="upload"
                                    >
                                        Upload
                                    </ui-button>
                                </div>
                            </ui-block>
                        </ui-row>
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
    challenges,
    subsPics,
}
from '../../../../dummies/PropagandAppContent'

import Utility from '../../../../Utilities'
import {
    UiBlock,
    UiBreadcrumbs,
    UiButton,
    UiContainer,
    UiFolderCorner,
    UiHeroBanner,
    UiHeroImage,
    UiImageSlider,
    UiLink,
    UiParagraph,
    UiRoadmap,
    UiSpecialText,
    UiTitle,
    UiRow,
}
from '../../../../ui'

import {
    UiAppBlock,
    UiAppDepthTexts,
    UiAppChallengesBreadcrumbs,
    UiAppPropagandaPlayer,
}
from '../../../../uiapp'

export default {
    name: 'ChallengeSingle',
    components: {
        UiAppBlock,
        UiAppChallengesBreadcrumbs,
        UiBlock,
        UiBreadcrumbs,
        UiButton,
        UiContainer,
        UiFolderCorner,
        UiHeroBanner,
        UiHeroImage,
        UiImageSlider,
        UiLink,
        UiParagraph,
        UiRoadmap,
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    data: function () {
        return {
            images: subsPics,
            title: null,
            content: null,
            open: false,
            description: null,
            buttonText: 'Open existing session',
        }
    },
    watch: {
        content: function (content) {
            this.description = content.description
        },
    },
    computed: {},
    methods: {
        getData: function () {
            let id = 3
            // perform api call
            this.content = challenges.find(challenge => challenge.id == id)

            this.debug()
        },
        debug: function () {
            console.log(this.content);
            // this.selectChannel(this.channels[2])
        },
        enter: function () {},
        leave: function () {},
        filesChange: function (name, files) {
            this.file = files[0]
            this.error_msg = null
            console.log(files);
        },
        upload: function () {
            let data = new FormData()
            data.append('token', 'dummy')
            data.append('title', this.title)
            data.append('media', this.file)
            data.append('slug', this.app.slug)
            data.append('category_slug', this.app.category.slug)
            data.append('studio_slug', this.app.category.section.slug)
            data.append('_method', 'put')

            let config = {
                headers: {
                    "Content-Type": "multipart/form-data"
                },
                onUploadProgress: function (progressEvent) {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    console.log(progressEvent, percentCompleted);
                }.bind(this)
            }

            this.$http.post('/api/v2/contest-upload', data, config).then(response => {
                console.log(response.data);
                this.saveContent()
            }).catch(err => {
                console.log(err);
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

.prop-affiches {
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
</style>
