<template lang="html">
    <ui-folder
        :title="app.title"
        :app="app.title"
        :appPath="app.slug"
        :cat="app.category.name"
        :catPath="app.category.slug"
        :pavilion="app.category.section.name"
        :pavilionPath="app.category.section.slug">
        <ui-paragraph v-html="app.description" />
        <ui-paragraph :full-width="true">
            <ui-button
                color="dark"
                :has-container="false"
                align-self="start">
                Read More
            </ui-button>
        </ui-paragraph>
    </ui-folder>
</template>

<script>
import { UiButton, UiFolder, UiParagraph } from '../ui'
export default {
    name: 'UiAppFolder',
    components: {
        UiButton,
        UiFolder,
        UiParagraph,
    },
    props: {
        app: {
            type: Object,
            default: function() {},
            required: true
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
