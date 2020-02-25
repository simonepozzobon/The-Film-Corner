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
                :app="content | translate('title', $root.locale)"
                :clip-name="clip | translate('title', $root.locale)"
                :clip-id="clip.id"
                class="prop-app-folder__breadcrumbs"
            />
            <ui-folder-corner
                :has-times="isOpen"
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
                :title="content | translate('title', $root.locale)"
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
import TranslationFilter from '../../../TranslationFilter'
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
    mixins: [TranslationFilter],
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
            isOpen: true,
            description: null,
            buttonText: null,
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
                this.close()
            }
        },
        togglePanel: function () {
            if (this.isOpen) {
                this.close()
            }
            else {
                this.open()
            }
        },
        open: function () {
            this.buttonText = this.$root.getCmd('close')
            this.isOpen = true
            this.$nextTick(() => {
                this.description = this.$options.filters.translate(this.content, 'description', this.$root.locale)
            })
        },
        close: function () {
            this.buttonText = this.$root.getCmd('read_more')
            this.isOpen = false
            let description = this.$options.filters.translate(this.content, 'description', this.$root.locale)
            this.description = clipper(description, 150, {
                html: true
            })
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.setDescription()
        })
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
