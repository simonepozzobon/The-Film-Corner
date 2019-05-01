<template lang="html">
    <ui-container :contain="true" class="ui-folder">
        <ui-row class="ui-folder__head">
            <ui-block
                size="auto"
                direction="row"
                align="end"
                justify="end">
                <ui-breadcrumbs
                    :app="app"
                    :appPath="appPath"
                    :cat="cat"
                    :catPath="catPath"
                    :pavilion="pavilion"
                    :pavilionPath="pavilionPath"
                    class="ui-folder__breadcrumbs"/>
                <ui-folder-corner
                    :has-times="hasTimes"
                    class="ui-folder__corner"/>
            </ui-block>
        </ui-row>
        <ui-row
            justify="center">
            <ui-block
                size="auto"
                color="green"
                :radius="true"
                radius-size="md">
                <ui-title
                    :title="title"
                    tag="h2"
                    font-size="h2"
                    :has-padding="false"
                    :has-margin="false"
                    class="ui-folder__title"/>
                <slot></slot>
            </ui-block>
        </ui-row>
    </ui-container>
</template>

<script>
import UiBlock from './UiBlock.vue'
import UiBreadcrumbs from './UiBreadcrumbs.vue'
import UiButton from './UiButton.vue'
import UiContainer from './UiContainer.vue'
import UiFolderCorner from './UiFolderCorner.vue'
import UiHeroBanner from './UiHeroBanner.vue'
import UiList from './UiList.vue'
import UiListItem from './UiListItem.vue'
import UiParagraph from './UiParagraph.vue'
import UiRow from './UiRow.vue'
import UiSpecialText from './UiSpecialText.vue'
import UiTitle from './UiTitle.vue'

export default {
    name: 'UiFolder',
    components: {
        UiBlock,
        UiBreadcrumbs,
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
        title: {
            type: String,
            default: 'Title'
        },
        app: {
            type: String,
            default: null,
            required: true,
        },
        appPath: {
            type: String,
            default: null,
            required: true,
        },
        cat: {
            type: String,
            default: null,
            required: true,
        },
        catPath: {
            type: String,
            default: null,
            required: true,
        },
        pavilion: {
            type: String,
            default: null,
            required: true,
        },
        pavilionPath: {
            type: String,
            default: null,
            required: true,
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

.ui-folder {
    $self: &;

    &__title {
        padding-top: $spacer * 2.6;
        padding-bottom: $spacer * 2.6;
    }
}

.ui-folder__title > .ui-title {
    margin: 0;
    padding: 0;
}
</style>
