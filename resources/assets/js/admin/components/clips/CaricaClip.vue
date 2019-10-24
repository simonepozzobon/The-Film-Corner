<template>
<div class="a-clip-panel__group">
    <ui-title
        title="Carica Clip"
        tag="span"
        font-size="h5"
        :has-padding="false"
        :has-margin="false"
        :has-container="false"
    />
    <hr class="a-clip-panel__divider">

    <div class="a-clip-panel__row form-group row">
        <label
            for="title"
            class="col-md-1"
        >
            Titolo
        </label>
        <div class="col-md-11">
            <input
                type="text"
                name="title"
                class="form-control"
                v-model="title"
            />
        </div>
    </div>

    <file-input
        label="Video"
        name="video"
        accept="video/mp4"
        label-size="col-md-1"
        input-size="col-md-11"
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
    name: 'CaricaClip',
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
    data: function () {
        return {
            title: null,
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.a-clip-panel__group {
    background-color: rgba($red, .3);
}
</style>
