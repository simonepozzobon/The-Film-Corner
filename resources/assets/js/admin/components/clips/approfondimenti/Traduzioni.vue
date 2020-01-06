<template>
<container
    :contains="true"
    :top-margin="false"
    padding="no"
>
    <block-panel
        ref="panel"
        :title="title"
        title-size="h6"
    >
        <text-editor
            ref="tech_info"
            :has-animation="true"
            label="Informazioni Tecniche"
            @ready="editorReady('tech_info')"
            @update="update('tech_info', arguments)"
        />

        <text-editor
            ref="abstract"
            :has-animation="true"
            label="Abstract"
            @ready="editorReady('abstract')"
            @update="update('abstract', arguments)"
        />

        <text-editor
            ref="historical_context"
            :has-animation="true"
            label="Contesto Storico"
            @ready="editorReady('historical_context')"
            @update="update('historical_context', arguments)"
        />

        <text-editor
            ref="foods"
            :has-animation="true"
            label="Food for thoughts"
            @ready="editorReady('foods')"
            @update="update('foods', arguments)"
        />
    </block-panel>
</container>
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
from '../../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../../ui'

export default {
    name: 'Traduzioni',
    components: {
        BlockPanel,
        Container,
        TextEditor,
        UiTitle,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        initials: {
            type: Object,
            default: function () {
                return {}
            },
        },
        debug: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            items: 4,
            initialized: false,
            values: {
                tech_info: null,
                abstract: null,
                historical_context: null,
                foods: null,
            }
        }
    },
    watch: {
        initials: function () {
            this.setInitials()
        },
        values: {
            handler: function (values) {
                this.$emit('update', values)
            },
            deep: true
        },
    },
    computed: {
        hasDebug: function () {
            if (this.debug) {
                return true
            }
            return false
        }
    },
    methods: {
        setInitials: function () {
            for (let key in this.initials) {
                if (this.initials.hasOwnProperty(key) && this.$refs.hasOwnProperty(key) && this.$refs[key].editor) {
                    this.$refs[key].editor.setContent(this.initials[key])
                    this.values[key] = this.initials[key]
                }
            }
        },
        editorReady: function () {
            this.items = this.items - 1
            if (this.items == 0 && this.initialized == false) {
                this.initialized = true
                this.$refs.panel.toggleAnim()
            }

            this.$nextTick(() => {
                this.setInitials()
            })
        },
        update: function (key, values = arguments) {
            let value = values[1]
            this.values[key] = value
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.setInitials()
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
