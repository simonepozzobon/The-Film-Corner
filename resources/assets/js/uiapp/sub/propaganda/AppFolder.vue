<template>
<ui-container
    :contain="true"
    class="prop-app-folder"
    v-if="content"
>
    <ui-row class="prop-app-folder__head">
        <ui-block
            size="auto"
            direction="row"
            align="end"
            justify="end"
        >
            <ui-app-propaganda-breadcrumbs
                :app="content.title"
                :clip-name="clip.title"
                :clip-id="clip.id"
                class="prop-app-folder__breadcrumbs"
            />
            <ui-folder-corner
                :has-times="open"
                color="dark-gray"
                class="prop-app-folder__corner"
                @click="togglePanel"
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
                :title="content.title"
                tag="h2"
                font-size="h2"
                :has-padding="false"
                :has-margin="false"
                color="white"
                class="prop-app-folder__title"
            />
            <ui-paragraph
                color="white"
                class="pt-5 prop-ex-container__paragraph"
                align="justify"
                v-html="description"
            />
            <div class="pb-4">
                <ui-button
                    color="light"
                    display="inline-block"
                    @click="togglePanel"
                >
                    {{ buttonText }}
                </ui-button>
            </div>
        </ui-block>
    </ui-row>
</ui-container>
</template>

<script>
const clipper = require('text-clipper')
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
from '../../../ui'

import {
    UiAppPropagandaBreadcrumbs,
}
from '../../../uiapp'

export default {
    name: 'AppFolder',
    components: {
        UiAppPropagandaBreadcrumbs,
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
    props: {
        content: {
            type: Object,
            default: function () {
                return {}
            },
        },
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            open: false,
            description: null,
            buttonText: 'Read More',
        }
    },
    watch: {
        content: function (content) {
            this.setDescription()
        },
    },
    methods: {
        setDescription: function () {
            if (this.content) {
                this.description = this.content.description
            }
        },
        togglePanel: function () {
            if (this.open) {
                this.open = false
                this.description = this.content.description
                this.buttonText = 'Read More'
            }
            else {
                this.open = true
                this.description = clipper(this.content.description, 150, {
                    html: true
                })
                this.buttonText = 'Close'
            }
        },
    },
    mounted: function () {
        this.setDescription()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.prop-app-folder {
    $self: &;

    &__description {
        padding-left: $spacer * 4;
        padding-right: $spacer * 4;
        margin-bottom: $spacer * 1.5;
        z-index: 1;
    }

    &__content {
        padding: 0;
        margin: 0;
    }

    &__title {
        padding-top: $spacer * 2.6;
        padding-bottom: $spacer * 2.6;
    }
}

.prop-app-folder__title > .ui-title {
    margin: 0;
    padding: 0;
}
</style>
