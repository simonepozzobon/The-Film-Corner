<template>
<ui-app-block
    :has-title="false"
    color="dark"
    align="center"
>
    <ui-button
        :title="$root.getCmd('crop_a_frame')"
        color="white"
        :has-container="false"
        :has-margin="false"
        @click="cropFrame"
    />
    <ui-button
        v-if="clearAll"
        :title="$root.getCmd('delete_all')"
        color="white"
        :has-container="false"
        :has-margin="false"
        @click="deleteAll"
    />
</ui-app-block>
</template>

<script>
import UiAppBlock from './UiAppBlock.vue'
import {
    UiButton
}
from '../ui'

export default {
    name: 'UiAppCropControls',
    components: {
        UiAppBlock,
        UiButton,
    },
    props: {
        clearAll: {
            type: Boolean,
            default: false,
        }
    },
    methods: {
        cropFrame: function () {
            this.$emit('crop-frame')
        },
        deleteAll: function () {
            this.$emit('delete-all')
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
