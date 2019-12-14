<template>
<block-panel
    title="Approfondimenti"
    ref="panel"
    :initial-state="state"
>
    <text-editor
        ref="tech_info"
        :has-animation="true"
        label="Informazioni Tecniche"
        @update="updateTechinfo"
        @ready="editorReady('tech_info')"
    />

    <text-editor
        ref="abstract"
        :has-animation="true"
        label="Abstract"
        @update="updateAbstract"
        @ready="editorReady('abstract')"
    />

    <text-editor
        ref="historical_context"
        :has-animation="true"
        label="Contesto Storico"
        @update="updateHistorical"
        @ready="editorReady('historical_context')"
    />

    <text-editor
        ref="foods"
        :has-animation="true"
        label="Food for thoughts"
        @update="updateFood"
        @ready="editorReady('foods')"
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
    props: {
        state: {
            type: Boolean,
            default: false,
        },
        initials: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            tech_info: null,
            abstract: null,
            historical_context: null,
            foods: null,
            keys: [
                'tech_info',
                'abstract',
                'historical_context',
                'foods',
            ],
        }
    },
    watch: {
        state: function (v) {
            this.$refs.panel.togglePanel()
        },
        initials: function (initials) {
            this.setInitials()
        },
    },
    methods: {
        setInitials: function () {
            for (let i = 0; i < this.keys.length; i++) {
                let key = this.keys[i]

                if (this.initials.hasOwnProperty(key) && this.$refs.hasOwnProperty(key) && this.$refs[key].editor) {
                    this.$refs[key].editor.setContent(this.initials[key])
                }
            }
        },
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
            this.foods = html
            this.$emit('update', 'foods', html)
        },
        editorReady: function (key) {
            this.setInitials()
        },
    },
    mounted: function () {
        this.setInitials()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
