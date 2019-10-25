<template>
<div class="a-clip-panel__group">
    <ui-title
        title="Approfondimenti"
        tag="span"
        font-size="h5"
        :has-padding="false"
        :has-margin="false"
        :has-container="false"
    />
    <hr class="a-clip-panel__divider">


    <text-editor
        ref="editor"
        :has-animation="true"
        label="Informazioni Tecniche"
    />

    <text-editor
        ref="editor"
        :has-animation="true"
        label="Abstract"
    />

    <text-editor
        ref="editor"
        :has-animation="true"
        label="Contesto Storico"
    />

    <text-editor
        ref="editor"
        :has-animation="true"
        label="Food for thoughts"
    />
</div>
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
    mounted: function () {
        console.log(this.$children);
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
