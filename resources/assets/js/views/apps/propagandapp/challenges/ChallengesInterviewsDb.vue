<template>
    <ui-container>
        <div class="propaganda-back">
            <div class="propaganda-back__container">
                <div class="propaganda-back__content">
                    <ui-container class="prop-ex-container">
                        <ui-container :contain="true" ref="folder">
                            <ui-row>
                                <ui-block
                                    size="auto"
                                    direction="row"
                                    align="end"
                                    justify="end"
                                >
                                    <ui-app-challenges-breadcrumbs
                                        app="Interviews"
                                    />

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
                                        :title="
                                            $root.getCmd('interview_database')
                                        "
                                        class="pt-5"
                                        color="white"
                                    />
                                    <ui-paragraph
                                        color="white"
                                        class="pt-5 prop-ex-container__paragraph"
                                        align="justify"
                                        v-html="
                                            $root.getCmd(
                                                'interview_database_text'
                                            )
                                        "
                                    />
                                </ui-block>
                            </ui-row>
                        </ui-container>
                        <ui-container :contain="true" class="mt-4">
                            <ui-row justify="center">
                                <ui-block
                                    :size="4"
                                    color="dark-gray"
                                    :radius="true"
                                    radius-size="md"
                                >
                                    <ui-title title="Video" color="white" />
                                    <ul class="ch-list list-unstyled">
                                        <li
                                            v-for="item in libraries.video"
                                            :key="item.id"
                                            class="ch-list__item"
                                        >
                                            <a
                                                href=""
                                                @click.prevent="
                                                    openModal('video', item)
                                                "
                                            >
                                                {{ item.title }}
                                            </a>
                                        </li>
                                    </ul>
                                </ui-block>
                                <ui-block
                                    :size="4"
                                    color="dark-gray"
                                    :radius="true"
                                    radius-size="md"
                                >
                                    <ui-title title="Audio" color="white" />
                                    <ul class="ch-list list-unstyled">
                                        <li
                                            v-for="item in libraries.audio"
                                            :key="item.id"
                                            class="ch-list__item"
                                        >
                                            <a
                                                href=""
                                                @click.prevent="
                                                    openModal('audio', item)
                                                "
                                            >
                                                {{ item.title }}
                                            </a>
                                        </li>
                                    </ul>
                                </ui-block>
                                <ui-block
                                    :size="4"
                                    color="dark-gray"
                                    :radius="true"
                                    radius-size="md"
                                >
                                    <ui-title title="Text" color="white" />
                                    <ul class="ch-list list-unstyled">
                                        <li
                                            v-for="item in libraries.text"
                                            :key="item.id"
                                            class="ch-list__item"
                                        >
                                            <a :href="item.url" target="_blank">
                                                {{ item.title }}
                                            </a>
                                        </li>
                                    </ul>
                                </ui-block>
                            </ui-row>
                        </ui-container>
                    </ui-container>
                    <challenge-modal
                        ref="modal"
                        :modal="modal"
                        :type="modalType"
                    />
                </div>
            </div>
        </div>
    </ui-container>
</template>

<script>
const clipper = require("text-clipper");
import { challenges, subsPics } from "../../../../dummies/PropagandAppContent";
import ChallengeModal from "../../../../uiapp/sub/propaganda/ChallengeModal.vue";
import Utility from "../../../../Utilities";
import TranslationFilter from "../../../../TranslationFilter";
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
    UiRow
} from "../../../../ui";

import {
    UiAppBlock,
    UiAppDepthTexts,
    UiAppChallengesBreadcrumbs,
    UiAppPropagandaPlayer
} from "../../../../uiapp";

export default {
    name: "ChallengeInterviewsDB",
    mixins: [TranslationFilter],
    components: {
        ChallengeModal,
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
        UiRow
    },
    data: function() {
        return {
            images: subsPics,
            title: null,
            content: null,
            open: false,
            description: null,
            buttonText: "Open existing session",
            modal: null,
            modalType: null,
            libraries: {
                video: [],
                audio: [],
                text: []
            }
        };
    },
    watch: {
        content: function(content) {}
    },
    computed: {},
    methods: {
        getData: function() {
            let id = 3;
            // perform api call
            // this.content = challenges.find(challenge => challenge.id == id)
            this.$http
                .get(`/api/v2/propaganda/challenge/${id}`)
                .then(response => {
                    if (response.data.success) {
                        const { challenge, library } = response.data;

                        this.content = challenge;
                        // console.log(library);

                        library.medias.map(item => {
                            let ext = item.url.split(".").pop();
                            // console.log("ext", ext);
                            ext = ext.toLowerCase();
                            if (ext == "mp3" || ext == "wav" || ext == "aiff") {
                                this.libraries.audio.push(item);
                            } else if (ext == "mp4" || ext == "mov") {
                                this.libraries.video.push(item);
                            } else if (
                                ext == "jpg" ||
                                ext == "jpeg" ||
                                ext == "png" ||
                                ext == "txt" ||
                                ext == "pdf"
                            ) {
                                this.libraries.text.push(item);
                            } else {
                                console.error("format not found", ext);
                            }
                        });
                    }
                })
                .catch(err => {
                    this.content = challenges.find(
                        challenge => challenge.id == id
                    );
                });

            this.debug();
        },
        debug: function() {
            console.log(this.content);
            // this.selectChannel(this.channels[2])
        },
        enter: function() {},
        leave: function() {},
        openModal: function(type, item) {
            this.modal = Object.assign({}, item);
            this.modalType = type;

            this.$nextTick(() => {
                this.$refs.modal.show();
            });
        },
        filesChange: function(name, files) {
            this.file = files[0];
            this.error_msg = null;
            // console.log(files);
        }
    },
    created: function() {
        this.getData();
    },
    mounted: function() {}
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
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

.ch-list {
    list-style: none;

    &__item {
        width: 100%;
        display: block;
        padding: $spacer;
        color: $white;
        text-align: center;
        border-bottom: 1px solid white;

        a {
            color: white;
        }
    }
}
</style>
