<template>
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="International Conference"
                    color="white"/>
                <ui-special-text color="white" align="center">
                    Downloads & Press
                </ui-special-text>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-title title="Downloads"/>
            <ui-row>
                <ui-block
                    :size="8"
                    :has-container="false"
                    align="start">
                    General Statement
                </ui-block>
                <ui-block
                    :size="4"
                    align="start"
                    direction="row">
                    <ui-button
                        color="primary">
                        Download
                    </ui-button>
                </ui-block>
            </ui-row>
            <ui-row>
                <ui-block
                    :size="8"
                    :has-container="false"
                    align="start">
                    Invitation
                </ui-block>
                <ui-block
                    :size="4"
                    align="start"
                    direction="row">
                    <ui-button
                        color="primary"
                        class="mr-2">
                        Download
                    </ui-button>
                    <ui-button
                        color="info"
                        :disable="true">
                        Apply
                    </ui-button>
                </ui-block>
            </ui-row>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-title title="Press"/>
            <ui-row>
                <ui-block
                    :size="8"
                    :has-container="false"
                    align="start">
                    International Conference - ENG
                </ui-block>
                <ui-block
                    :size="4"
                    align="start"
                    direction="row">
                    <ui-button
                        color="primary">
                        Download
                    </ui-button>
                </ui-block>
            </ui-row>
            <ui-row>
                <ui-block
                    :size="8"
                    :has-container="false"
                    align="start">
                    International Conference - ITA
                </ui-block>
                <ui-block
                    :size="4"
                    align="start"
                    direction="row">
                    <ui-button
                        color="primary">
                        Download
                    </ui-button>
                </ui-block>
            </ui-row>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTitle } from '../../ui'

export default {
    name: 'ConferenceContact',
    components: {
        UiBlock,
        UiButton,
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTitle,
    },
    data: function() {
        return {
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
