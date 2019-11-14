<template>
<ui-container
    :contain="true"
    class="net-folder"
>
    <ui-row class="net-folder__head">
        <ui-block
            size="auto"
            direction="row"
            align="end"
            justify="end"
        >
            <net-breadcrumbs
                class="net-folder__breadcrumbs"
                :app="app"
                :appPath="appPath"
                :cat="cat"
                :catPath="catPath"
            />
            <ui-folder-corner
                :has-times="hasTimes"
                :color="color"
                class="net-folder__corner"
            />
        </ui-block>
    </ui-row>
    <ui-row justify="center">
        <ui-block
            size="auto"
            :color="color"
            :radius="true"
            radius-size="md"
        >
            <ui-title
                :title="title"
                tag="h2"
                font-size="h2"
                :has-padding="false"
                :has-margin="false"
                class="net-folder__title"
            />
            <slot></slot>
        </ui-block>
    </ui-row>
</ui-container>
</template>

<script>
import {
    UiBlock,
    UiButton,
    UiContainer,
    UiFolderCorner,
    UiHeroBanner,
    UiList,
    UiListItem,
    UiParagraph,
    UiRow,
    UiSpecialText,
    UiTitle
}
from '../ui'
import NetBreadcrumbs from './NetBreadcrumbs.vue'

import TranslationFilter from '_js/TranslationFilter'

export default {
    name: 'UiFolder',
    mixins: [TranslationFilter],
    components: {
        NetBreadcrumbs,
        UiBlock,
        UiButton,
        UiContainer,
        UiFolderCorner,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTitle,
    },
    props: {
        color: {
            type: String,
            default: 'green'
        },
        title: {
            type: String,
            default: 'Title'
        },
        app: {
            type: String,
            default: null,
            // required: true,
        },
        appPath: {
            type: String,
            default: null,
            // required: true,
        },
        cat: {
            type: String,
            default: null,
            // required: true,
        },
        catPath: {
            type: String,
            default: null,
            // required: true,
        },
        hasTimes: {
            type: Boolean,
            default: false,
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.net-folder {
    $self: &;

    &__title {
        padding-top: $spacer * 2.6;
        padding-bottom: $spacer * 2.6;
    }
}

.net-folder__title > .ui-title {
    margin: 0;
    padding: 0;
}
</style>
