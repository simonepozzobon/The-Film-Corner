<template>
    <ui-container>
        <div class="propaganda-back">
            <div class="propaganda-back__container">
                <div class="propaganda-back__content">
                    <ui-container class="prop-ex-container" v-if="content">
                        <ui-container :contain="true" ref="folder">
                            <ui-row>
                                <ui-block
                                    size="auto"
                                    direction="row"
                                    align="end"
                                    justify="end"
                                >
                                    <ui-app-propaganda-breadcrumbs
                                        :app="
                                            content
                                                | translate(
                                                    'title',
                                                    $root.locale
                                                )
                                        "
                                        :clip-name="
                                            clip
                                                | translate(
                                                    'title',
                                                    $root.locale
                                                )
                                        "
                                        :clip-id="clip.id"
                                    />

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
                                        :title="
                                            content
                                                | translate(
                                                    'title',
                                                    $root.locale
                                                )
                                        "
                                        class="pt-5"
                                        color="white"
                                    />
                                    <ui-paragraph
                                        color="white"
                                        class="pt-5 prop-ex-container__paragraph"
                                        align="justify"
                                        v-html="translatedDescription"
                                    />
                                    <div class="pb-4">
                                        <ui-button
                                            color="light"
                                            display="inline-block"
                                            @click="startApp"
                                            :title="
                                                this.$root.getCmd(
                                                    'start_new_session'
                                                )
                                            "
                                        />
                                        <ui-button
                                            color="light"
                                            display="inline-block"
                                            @click="togglePanel"
                                            :title="buttonText"
                                        />
                                    </div>
                                </ui-block>
                            </ui-row>
                        </ui-container>
                        <ui-app-session-manager
                            :app="content"
                            :open="open"
                            :app-sessions="sessions"
                            @open-session="startApp"
                        />
                    </ui-container>
                </div>
            </div>
        </div>
    </ui-container>
</template>

<script>
const clipper = require("text-clipper");
import { movies } from "../../../dummies/PropagandAppContent";

import Utility from "../../../Utilities";
import TranslationFilter from "../../../TranslationFilter";
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
    UiRow
} from "../../../ui";

import {
    UiAppDepthTexts,
    UiAppPropagandaBreadcrumbs,
    UiAppPropagandaPlayer,
    UiAppSessionManager
} from "../../../uiapp";

export default {
    name: "PropagandaExercise",
    mixins: [TranslationFilter],
    components: {
        UiAppPropagandaBreadcrumbs,
        UiAppSessionManager,
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
        UiRow
    },
    data: function() {
        return {
            clip: null,
            title: null,
            content: null,
            open: false,
            description: null,
            buttonText: null,
            sessions: []
        };
    },
    watch: {
        content: function(content) {
            console.log("qui content", content);
            if (content && content.hasOwnProperty("description")) {
                this.description = content.description;
            } else {
                this.description = null;
            }
        },
        "$root.locale": function(locale) {
            this.translateExercise();
        }
    },
    computed: {
        translatedDescription: function() {
            return this.$options.filters.translate(
                this.content,
                "description",
                this.$root.locale
            );
        }
    },
    methods: {
        translateExercise: function() {
            this.description = this.translateContent("description");
            this.title = this.translateContent("title");
        },
        translateContent: function(key) {
            // if (this.content) {
            let item = this.content.translations.find(
                translation => translation.locale == this.$root.locale
            );

            if (item) {
                return item[key];
            }

            return this.content[key];
            // }
            // return null;
        },
        getData: function() {
            let id = this.$route.params.id;
            let exerciseId = this.$route.params.exerciseId;

            // perform api call
            console.log(`id -> ${id}`, `exerciseId -> ${exerciseId}`);
            let url = `/api/v2/propaganda/clip/${id}/exercise/${exerciseId}/navigation`;
            this.$http.get(url).then(response => {
                console.log("risposta navigazione", response.data);
                const { clip, exercise, sessions } = response.data;

                this.clip = clip;
                this.content = exercise;
                this.sessions = sessions;

                this.buttonText = this.$root.getCmd("open_existing_session");

                this.translateExercise();
            });

            // this.clip = movies.find(movie => movie.id == id)
            // this.content = this.clip.exercises.find(exercise => exercise.id == exerciseId)
            // this.debug()
        },
        debug: function() {
            console.log(this.content);
            // this.selectChannel(this.channels[2])
        },
        enter: function() {},
        leave: function() {},
        startApp: function() {
            console.log(this.content.slug);
            let slug = this.content.slug;
            this.$root.goTo(slug);
        },
        togglePanel: function() {
            if (this.open) {
                this.open = false;
                this.description = this.$options.filters.translate(
                    this.content,
                    "description",
                    this.$root.locale
                );
                this.buttonText = this.$root.getCmd("open_existing_session");
            } else {
                this.open = true;
                let description = this.$options.filters.translate(
                    this.content,
                    "description",
                    this.$root.locale
                );
                this.description = clipper(description, 150, {
                    html: true
                });
                this.buttonText = this.$root.getCmd("close_panel");
            }
        }
    },
    created: function() {
        // console.log("gettin data");
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

.prop-ex-container {
    // margin-top: $spacer * 5;

    &__paragraph-container {
        // display: flex;
        // flex-direction: column;
        // justify-content: flex-start;
    }

    &__paragraph {
    }

    &--is-open &__paragraph {
    }
}
</style>
