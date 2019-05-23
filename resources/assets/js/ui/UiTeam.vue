<template lang="html">
    <ui-container class="mb-4">
        <ui-row>
            <ui-block :size="4">
                <ui-image
                    v-if="img"
                    :src="img"
                    :alt="name"
                    :full-width="true"/>
            </ui-block>
            <ui-block :size="8">
                <ui-paragraph :has-padding="false">
                    <ui-title
                        tag="h3"
                        :title="name"
                        :has-padding="false"/>
                    <slot></slot>
                </ui-paragraph>
            </ui-block>
        </ui-row>
    </ui-container>
</template>

<script>
import UiBlock from './UiBlock.vue'
import UiContainer from './UiContainer.vue'
import UiImage from './UiImage.vue'
import UiParagraph from './UiParagraph.vue'
import UiRow from './UiRow.vue'
import UiTitle from './UiTitle.vue'

export default {
    name: 'UiTeam',
    components: {
        UiBlock,
        UiContainer,
        UiImage,
        UiParagraph,
        UiRow,
        UiTitle,
    },
    props: {
        name: {
            type: String,
            default: 'Name'
        },
        img: {
            type: String,
            default: null,
        },
    }

}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
