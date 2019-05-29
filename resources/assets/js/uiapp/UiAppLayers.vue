<template>
    <ui-row :no-gutters="true">
        <ui-block :size="12">
            <div class="ui-app-layers">
                <ui-title :title="title" color="white" :has-padding="false"/>
                <div class="ui-app-layers__list">
                    <layer-single
                        v-for="(layer, i) in layers"
                        :key="i"
                        ref="layer"
                        :idx="i"
                        :layer="layer"
                        @select-layer="selectLayer"
                        @delete-layer="deleteLayer"/>
                </div>
            </div>
        </ui-block>
    </ui-row>
</template>

<script>
import LayerSingle from './sub/layers/LayerSingle.vue'
import { UiBlock, UiTitle, UiRow } from '../ui'

export default {
    name: 'UiAppLayers',
    components: {
        LayerSingle,
        UiBlock,
        UiTitle,
        UiRow,
    },
    props: {
        title: {
            type: String,
            default: 'Layers',
        },
        layers: {
            type: Array,
            default: function() {}
        },
    },
    methods: {
        selectLayer: function(idx) {
            this.$emit('select-layer', idx)
        },
        deleteLayer: function(idx) {
            this.$emit('delete-layer', idx)
        },
    },
    mounted: function() {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-layers {
    background-color: $dark-gray;
    width: 100%;
    padding: $spacer;
    @include border-radius($custom-border-radius);
    @include app-block-padding;
}
</style>
