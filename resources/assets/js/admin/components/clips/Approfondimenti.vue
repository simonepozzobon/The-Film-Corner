<template>
<block-panel title="Approfondimenti">
    <text-editor
        :has-animation="true"
        label="Informazioni Tecniche"
        @update="updateTechinfo"
    />

    <text-editor
        ref="editor"
        :has-animation="true"
        label="Abstract"
        @update="updateAbstract"
    />

    <text-editor
        ref="editor"
        :has-animation="true"
        label="Contesto Storico"
        @update="updateHistorical"
    />

    <text-editor
        ref="editor"
        :has-animation="true"
        label="Food for thoughts"
        @update="updateFood"
    />
</block-panel>
</template>

<script>
import {
    BlockPanel,
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'Approfondimenti',
    components: {
        BlockPanel,
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
    },
    data: function () {
        return {
            tech_info: null,
            abstract: null,
            historical_context: null,
            food: null,
        }
    },
    methods: {
        updateTechinfo: function (json, html) {
            this.tech_info = html
            this.$emit('update', 'tech_info', html)
        },
        updateAbstract: function (json, html) {
            this.abstract = html
            this.$emit('update', 'abstract', html)
        },
        updateHistorical: function (json, html) {
            this.historical_context = html
            this.$emit('update', 'historical_context', html)
        },
        updateFood: function (json, html) {
            this.food = html
            this.$emit('update', 'food', html)
        },
    },
    mounted: function () {},
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
