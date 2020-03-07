<template>
<block-panel title="Esercizi">
    <div class="a-clip-panel__row form-group row">
        <label class="col-md-2">
            Compare The Clips
        </label>
        <switch-input
            label="Compare The Clips"
            label-size="col-md-2"
            input-size="col-md-1"
            :has-row="false"
        />
        <label class="col-md-2 offset-md-1">
            Frame Crop
        </label>
        <switch-input
            label="Frame Crop"
            label-size="col-md-2"
            input-size="col-md-1"
            :has-row="false"
        />
        <label class="col-md-2 offset-md-1">
            Check The Sound
        </label>
        <switch-input
            label="
              Check
              The
              Sound"
            label-size="col-md-2"
            input-size="col-md-1"
            :has-row="false"
        />
    </div>
</block-panel>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
    BlockPanel,
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'Esercizi',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
        BlockPanel,
    },
    props: {
        options: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            period: null,
            year: null,
            region: null,
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
