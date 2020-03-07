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
                    <!-- <ui-app-session-manager
                        :app="this.app"
                        :open="open"
                        :app-sessions="sessions"
                        @open-session="startApp"
                    /> -->
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
}
from '../../../../ui'

import {
    UiAppDepthTexts,
    UiAppChallengesBreadcrumbs,
    UiAppPropagandaPlayer,
}
from '../../../../uiapp'

export default {
    name: 'ChallengeSingle',
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
    },
    data: function () {
        return {
            clip: null,
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
            let id = 2
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
