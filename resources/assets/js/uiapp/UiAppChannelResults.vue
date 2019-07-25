<template>
<ui-container>
    <ui-container :contain="true">
        <ui-title
            v-if="title"
            :is-main="true"
            :title="title"
        />
        <ui-row>
            <ui-block
                v-for="content in contents"
                :key="content.id"
                :size="6"
            >
                <single-result :content="content" />
            </ui-block>
        </ui-row>
    </ui-container>
</ui-container>
</template>

<script>
import {
    UiBlock,
    UiContainer,
    UiRow,
    UiTitle,
}
from '../ui'

import SingleResult from './sub/search-results/SingleResult.vue'

export default {
    name: 'UiAppChannelResults',
    components: {
        SingleResult,
        UiBlock,
        UiContainer,
        UiRow,
        UiTitle,
    },
    props: {
        contents: {
            type: Array,
            default: function () {
                return []
            },
        },
        title: {
            type: String,
            default: null,
        },
    },

}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
